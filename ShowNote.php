<?php

interface ShowNote
{
    public function printNotesPreview(Notes $note);
    public function printNotes(Notes $note);
    public function showPagination();

}