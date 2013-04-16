<?php
// pripojeni souboru obsahujici tridu
require_once 'AbstractModel.php';
require_once 'User.php';
require_once 'UserManager.php';

// pripojeni k databazi
AbstractModel::connect(array(	
	'host'		=> 'localhost',
	'dbname'	=> 'test',
	'username'	=> 'root',
	'password'	=> 'lamp',
	'charset'	=> 'utf8'
));
AbstractModel::setDebug(true);


// inicializace manazera uzivatelu
$users = new UserManager();

if (isset($_POST['delete'])) {
    // smazani uzivatele
    $users->removeUser((int) $_GET['id']);
    //  presmerovani na seznam uzivatelu
    header('Location: ' . $_SERVER['SCRIPT_NAME']);
} elseif (isset($_POST['edit'])) {
    // editace uzivatele
    $users->updateUser((int) $_GET['id'], $_POST['form']);
    //  presmerovani na seznam uzivatelu
    header('Location: ' . $_SERVER['SCRIPT_NAME']);
} elseif (isset($_POST['add'])) {
    // pridani uzivatele
    $users->createUser($_POST['form']);
    //  presmerovani na seznam uzivatelu
    header('Location: ' . $_SERVER['SCRIPT_NAME']);
} elseif (isset($_GET['id'])) {
    // nacteni informace o uzivateli
   	$user = $users->find((int) $_GET['id']);
}

?>

<html>
    <head>
        <meta charset="utf-8">
        <title>Příklad přepisu jednoduchého "špagetového kódu" do OOP</title>
    </head>
    <body>
        <form method="post">
            <?php if (isset($user)) { ?>
                <p>
                    <label>ID:</label>
                    <?php echo $user->getId() ?>
                </p>
            <?php } ?>
            <p>
                <label>Jméno:</label>
                <input type="text" name="form[firstname]"
                    value="<?php if (isset($user)) echo $user->getFirstname() ?>" />
            </p>
            <p>
                <label>Příjmení:</label>
                <input type="text" name="form[lastname]"
                    value="<?php if (isset($user)) echo $user->getLastname() ?>" />
            </p>

            <p>
                <input type="submit" name="add" value="Přidat nového uživatele" />
                <?php if (isset($user)) { ?>
                    <input type="submit" name="edit" value="Editovat uživatele" />
                    <input type="submit" name="delete" value="Smazat uživatele" />
                <?php } ?>
            </p>
        </form>      

        <h2>Počet uživatelů: <?php echo $users->count() ?></h2>
        <table>
            <tr>
                <th>#</th>
                <th>ID</th>
                <th>Jméno</th>
                <th>Příjmení</th>
                <th></th>
            </tr>
            <?php foreach ($users->fetchAll() as $index => $user) { ?>
                <tr>
                    <td><?php echo $index + 1 ?></td>
                    <td><?php echo $user->getId() ?></td>
                    <td><?php echo $user->getFirstname() ?></td>
                    <td><?php echo $user->getLastname() ?></td>
                    <td><a href="?id=<?php echo $user->getId() ?>">Upravit</a></td>
                </tr>
            <?php } ?>
        </table>
    </body>
</html>