<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?php 
    if( isset($_POST['a']) && isset($_POST['b']) && isset($_POST['operator'])) {
        $operator = $_POST['operator'];
        $result   = 0;

        switch( $operator ) {
            case 'sub':
                $result = $_POST['a'] - $_POST['b'];
                echo "Subtracting {$_POST['a']} and {$_POST['b']}";
                break;
            case 'mul':
                $result = $_POST['a'] * $_POST['b'];
                echo "Multiplying {$_POST['a']} and {$_POST['b']}";
                break;
            case 'div':
                $result = $_POST['a'] / $_POST['b'];
                echo 'Diving ' . $_POST['a'] . ' and ' . $_POST['b'];
                break;
            default:
                $result = $_POST['a'] + $_POST['b'];
                echo "Adding {$_POST['a']} and {$_POST['b']}";
                break;
        }

        echo "<br /> Result: {$result}";
    }
?>

    <form onsubmit="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <label> A: </label>
        <input type="number" name="a" />
        <br />
        <label> B: </label>
        <input type="number" name="b" />
        <br />

        <label> Operator: </label>
        <select name="operator">
            <option value="add">Addition</option>
            <option value="sub">Subtraction</option>
            <option value="mul">Multiplication</option>
            <option value="div">Division</option>
        </select>
        <button type="submit">Submit</button>
    </form>
</body>
</html>

