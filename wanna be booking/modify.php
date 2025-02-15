<?php
require 'db_connection.php';
session_start();
include 'track_visit.php';

// Obținem lista de tabele din baza de date
$tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

// Dacă s-a selectat o tabelă
$selected_table = $_GET['table'] ?? null;
$records = [];
$columns = [];

if ($selected_table && in_array($selected_table, $tables)) {
    // Obținem coloanele tabelului selectat
    $stmt = $pdo->prepare("DESCRIBE $selected_table");
    $stmt->execute();
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Obținem toate înregistrările din tabelul selectat
    $stmt = $pdo->prepare("SELECT * FROM $selected_table");
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Dacă s-a trimis un formular pentru modificare sau ștergere
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        // Ștergem înregistrarea
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM $selected_table WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: modify.php?table=$selected_table");
        exit;
    } elseif (isset($_POST['update'])) {
        // Actualizăm înregistrarea
        $id = $_POST['id'];
        $updates = [];
        $values = [];

        foreach ($_POST as $key => $value) {
            if ($key !== 'id' && $key !== 'update' && in_array($key, $columns)) {
                $updates[] = "$key = ?";
                $values[] = $value;
            }
        }

        // Verificări specifice pentru tabelul `reservations`
        if ($selected_table === 'reservations') {
            // Preluăm datele rezervării
            $stmt = $pdo->prepare("SELECT room_id, check_in, check_out FROM reservations WHERE id = ?");
            $stmt->execute([$id]);
            $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificăm dacă camera este deja rezervată în perioada respectivă
            $stmt = $pdo->prepare("
                SELECT 1 
                FROM reservations
                WHERE room_id = ?
                AND status = 'confirmed'
                AND id != ?
                AND (
                    (? BETWEEN check_in AND check_out)
                    OR (? BETWEEN check_in AND check_out)
                    OR (check_in BETWEEN ? AND ?)
                    OR (check_out BETWEEN ? AND ?)
                )
            ");
            $stmt->execute([
                $reservation['room_id'],
                $id,
                $_POST['check_in'], $_POST['check_out'],
                $_POST['check_in'], $_POST['check_out'],
                $_POST['check_in'], $_POST['check_out']
            ]);
            $is_room_booked = $stmt->fetch();

            if ($is_room_booked) {
                $error_message = 'The room is already booked for this period.';
            }

            // Verificăm dacă data de check-out este cel puțin o zi după check-in
            $check_in = new DateTime($_POST['check_in']);
            $check_out = new DateTime($_POST['check_out']);
            if ($check_out <= $check_in) {
                $error_message = 'Check-out date must be at least one day after check-in date.';
            }

            // Verificăm dacă data de check-in este anterioară datei curente
            $current_date = new DateTime();
            if ($check_in < $current_date) {
                $error_message = 'Check-in date cannot be in the past.';
            }
        }

        // Dacă nu există erori, actualizăm înregistrarea
        if (!isset($error_message)) {
            $sql = "UPDATE $selected_table SET " . implode(', ', $updates) . " WHERE id = ?";
            $values[] = $id;
            $stmt = $pdo->prepare($sql);
            $stmt->execute($values);
            header("Location: modify.php?table=$selected_table");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Database</title>
    <link rel="stylesheet" href="modify.css">
</head>
<body>
    <div class="wrapper">
        <h1>Modifică Baza de Date</h1>
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="get">
            <label for="table">Selectează tabela:</label>
            <select name="table" id="table" onchange="this.form.submit()">
                <option value="">-- Alege o tabelă --</option>
                <?php foreach ($tables as $table): ?>
                    <option value="<?php echo $table; ?>" <?php echo $selected_table === $table ? 'selected' : ''; ?>>
                        <?php echo $table; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <?php if ($selected_table): ?>
            <h2>Înregistrări din tabela <?php echo $selected_table; ?></h2>
            <table border="1">
                <thead>
                    <tr>
                        <?php foreach ($columns as $column): ?>
                            <th><?php echo $column; ?></th>
                        <?php endforeach; ?>
                        <th>Acțiuni</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $record): ?>
                        <tr>
                            <?php foreach ($columns as $column): ?>
                                <td><?php echo $record[$column]; ?></td>
                            <?php endforeach; ?>
                            <td>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $record['id']; ?>">
                                    <button type="submit" name="delete">Șterge</button>
                                </form>
                                <button onclick="editRecord(<?php echo $record['id']; ?>)">Modifică</button>
                            </td>
                        </tr>
                        <tr id="edit-<?php echo $record['id']; ?>" style="display:none;">
                            <form method="post">
                                <?php foreach ($columns as $column): ?>
                                    <td>
                                        <input type="text" name="<?php echo $column; ?>" value="<?php echo $record[$column]; ?>">
                                    </td>
                                <?php endforeach; ?>
                                <td>
                                    <input type="hidden" name="id" value="<?php echo $record['id']; ?>">
                                    <button type="submit" name="update">Salvează</button>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script>
        function editRecord(id) {
            document.getElementById('edit-' + id).style.display = 'table-row';
        }
    </script>
</body>
</html>