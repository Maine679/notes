<?php


class Pagination
{
    private static int $countRowOnPage = 1;
    private static int $numCurrentPage = 1;


    public static function getNumCurrentPage(): int
    {
        return self::$numCurrentPage;
    }
    public static function setNumCurrentPage(int $numCurrentPage): void
    {
        if($numCurrentPage <= 0)
            self::$numCurrentPage = 0;
        else
            self::$numCurrentPage = $numCurrentPage;
    }

    //Сколько записей может быть на странице. (Получить/установить)
    public function getCountRowOnPage() {
        return self::$countRowOnPage;
    }
    public function  setCountRowOnPage($count) {
        if($count < 3) {
            self::$countRowOnPage = 3;
        } else if($count > 20) {
            self::$countRowOnPage = 20;
        } else {
            self::$countRowOnPage = $count;
        }
    }

    public function getCountAllPage(IONotesData $ioObj,$authorId = -1) {
        $iAllCount = $ioObj->getCountNotes($authorId);
        return floor($iAllCount / self::$countRowOnPage);
    }

    public function getCountNotes(IONotesData $ioObj,$authorId = -1) { //Такая же как в заметках. Хорошо или плохо?
        return $ioObj->getCountNotes($authorId);
    }
}