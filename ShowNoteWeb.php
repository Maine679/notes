<?php

require_once "ShowNote.php";
require_once "Pagination.php";

class ShowNoteWeb implements ShowNote
{
    //Выводит пагинацию на странице (Если в этом есть необходимость)
    public function showPagination(Notes $notes, Pagination $pagination,IONotesData $IONotesData, $userId )
    {
//        Если показываем в середине.
//        [first] [curr-1][curr][curr+1] [last]
//              [1][2]  [6]
//           [1][2][3]  [6]
//      [1]  [2][3][4]  [6]
//      [1]  [4][5][6]
//
//      [Начало]
//
//
        $lastPage = $pagination->getCountAllPage($IONotesData,$userId);
        $currPage = $pagination::getNumCurrentPage();
        echo "<br>currpage $currPage lastPage $lastPage<br>";

        echo '<form method="POST">';
        if($currPage >= 2)
            echo '<input type="submit" name="button_page" value="0" />';



        if($currPage > 0)
            echo '<input type="submit" name="button_page" value="' . ($currPage -1) . '" />';

        echo '<input type="submit" name="button_page" value="' . $currPage . '" />';

        if($currPage + 1 <= $lastPage)
            echo '<input type="submit" name="button_page" value="' . ($currPage +1) . '" />';


        if($currPage <= $lastPage - 2)
            echo '<input type="submit" name="button_page" value="'. $lastPage . '" />';

        echo '</form>';
    }




    public function printNotesPreview(Notes $note)
    {
        echo "<br>___________________________________________________________";
        echo "<br><br><b>" . $note->getTitle() . "</b>";
        echo "<br> " . $note->getPreview() .  " ";

        echo '<form method="POST">
            <input type="submit" name="button_more ' . $note->getNoteId() . '" value="Подробнее" />
        </form>';
    }
    public function printNotes(Notes $note)
    {

    }
}