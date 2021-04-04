<?php
session_start();

require_once "Users.php";
require_once "Notes.php";
require_once "IONotesDataDB.php";
require_once "Pagination.php";
require_once "ShowNoteWeb.php";

$newUser = new Users();


//Получаем данные.
$button_back = $_POST['button_back'];
$button_exit = $_POST['button_exit'];

if($button_exit) {
    unset($_SESSION['user_id']);
} else {
    //Для того что бы проверить залогинился пользователь или нет.
    if(isset($_SESSION['user_id'])) {
        $newUser->authorization("", "", $_SESSION['user_id']);
    }
}
    

if(empty($button_back) || !empty($button_exit)) {
    $login = $_POST['login'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $password = $_POST['password'];
    $password_try = $_POST['password_try'];
    $button_authorization = $_POST['button_authorization'];
    $button_registration = $_POST['button_registration'];
    $authorization = $_POST['authorization'];
    $registration = $_POST['registration'];
}


if($registration && !$newUser->getAuthorized()) {

    if(empty($login)) {
        echo "Вы не ввели логин.";
    } else if($newUser->user_exists($login)) {
        echo "Этот логин зарезервирован в системе, придумайте другой.";
        $login = "";
    } else
    if(empty($name)) {
        echo "Вы не ввели имя.";
    } else
    if(empty($password)) {
        echo "Вы не ввели пароль.";
    } else
    if(empty($password_try)) {
        echo "Вы не ввели подтверждение пароля.";
    } else
    if($password !== $password_try) {
        echo "Вы ввели несовпадающие пароли.";
    } else {
        $result = $newUser->registration($login,$password,$name,$surname);
        if($result) {
            echo "Регистрация успешна. Теперь можно оставлять заметки и просматривать предыдущие.";
            $newUser->setAuthorized(true);

        } else {
            echo "Произошел сбой в регистрации, попробуйте ещё раз.";
        }
    }
} else if($authorization && !$newUser->getAuthorized()) {
    if(empty($login)) {
        echo "Вы не ввели логин.";
    } else if(empty($password)) {
        echo "Вы не ввели пароль.";
    } else {
        $result = $newUser->authorization($login,$password);
        if(!$result) {
            echo "Логин или пароль не правильный. Проверьте правильность логина и пароля.";
        }
    }
}


if(!$newUser->getAuthorized()) {
    if ($button_registration || $registration) {
        echo "<br><br><form action='index.php' method='post'>
     <p>Введите логин: <input type='text' name='login' value='$login' /></p>
     <p>Ваше имя: <input type='text' name='name' value='$name' /></p>
     <p>Ваше фамилию: <input type='text' name='surname' value='$surname' /></p>
     <p>Пароль: <input type='password' name='password' /></p>
     <p>Подтвердите пароль: <input type='password' name='password_try' /></p>
     <p><input type='submit' name='registration' value='Регистрация' /></p>
     <input type='submit' name='button_back' value='Назад' />
    </form><br><br>";
    } else if ($button_authorization || $authorization) {
        echo "<br><br><form action='index.php' method='post'>
     <p> логин: <input type='text' name='login' value='$login' /></p>
     <p>Пароль: <input type='password' name='password' /></p>
     <p><input type='submit' name='authorization'  value='Вход' /></p>
     <input type='submit' name='button_back' value='Назад' />
    </form><br><br>";
    } else {
        echo '<br><br>
    <form method="POST">
        <input type="submit" name="button_authorization" value="Вход" />
        <input type="submit" name="button_registration" value="Регистрация" />
    </form>
    ';
    }
} else {
    echo '<br><br><form method="POST">
        <input type="submit" name="button_exit" value="Выход" />
    </form>';

    echo "Здесь будут записи!";


    $ioNoteDB = new IONotesDataDB();
    $pagObj = new Pagination();

    $noteObj = new Notes();

    $iSetPage = $_POST['button_page'];
    if($iSetPage >= 0)
        $pagObj::setNumCurrentPage((int)$iSetPage);




    //Всего записей
    echo "<br> Всего записей " . $iCountNote = $pagObj->getCountNotes($ioNoteDB,$newUser->getUserId()); //общее количество записей

    echo "<br> Текущая страниц " . $iPage = $pagObj->getNumCurrentPage(); //Страница

    echo "<br> Всего страниц  " . $iAllPage = $pagObj->getCountAllPage($ioNoteDB,$newUser->getUserId());   //Сколько всего страниц
    echo "<br> Количество записей на странице  " . $iCountOnPage = $pagObj->getCountRowOnPage(); //Количество записей на странице

    $arrNoteObj = $noteObj->readAllNotes($ioNoteDB,$newUser->getUserId()); //Получили данные обо всех заметках.
//    $noteObj->getPreview();

    echo "<br><br>";

    $iIterator = min($iPage * $iCountOnPage, $iCountNote); // 2
    $iStart = $iIterator - ($iIterator % $iCountOnPage);
    $iEnd = min($iStart + $iCountOnPage, $iCountNote);
    $iPage = floor($iStart / $iCountOnPage);


    $showNoteObj = new ShowNoteWeb();
    for($i = $iIterator;$i<$iEnd;$i++) {
        $showNoteObj->printNotesPreview($arrNoteObj[$i]);
    }

    if($iAllPage > 0)
        $showNoteObj->showPagination($noteObj,$pagObj,$ioNoteDB,$newUser->getUserId());

}
















