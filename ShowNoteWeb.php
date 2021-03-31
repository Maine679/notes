<?php

require_once "ShowNote.php";

class ShowNoteWeb implements ShowNote
{
    //Выводит пагинацию на странице (Если в этом есть необходимость)
    public function showPagination()
    {
        // TODO: Implement showPagination() method.
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