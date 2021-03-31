<?php



class Notes
{
    private $notes_id = -1;
    private $notes_title;
    private $notes_text_preview;
    private $notes_text;
    private $notes_author_id = -1; //А нужно ли нам это???

    public function getNoteId() : int {
        return $this->notes_id;
    }
    public function getTitle() {
        return $this->notes_title;
    }
    public function getPreview() {
        return $this->notes_text_preview;
    }
    public function getText() {
        return $this->notes_text;
    }

    public function readAllNotes(IONotesData $ioObj,$authorId) : array {
        $arrData = $ioObj->getAllNotes($authorId);

        $arrNoteObj = array();

        foreach ($arrData as $key => $value) {
            $objNote = new Notes();

            $objNote->notes_id = $value["notes_id"];
            $objNote->notes_title = $value["notes_title"];
            $objNote->notes_text_preview = $value["notes_text_preview"];
            $objNote->notes_text = $value["notes_text"];
            $objNote->notes_author_id = $value["notes_author_id"];

            $arrNoteObj[] = $objNote;
        }
        return $arrNoteObj;
    }
    public function getCountNotes(IONotesData $ioObj,$authorId) {
        if($authorId != -1)
            return $ioObj->getCountNotes($authorId);
        return 0;
    }
    public function getAuthorId() {
        if($this->notes_author_id == -1) {
            printf("Ошибка! Данные в объект не загружены.\n");
            exit;
        }

        return $this->notes_author_id;
    }
}