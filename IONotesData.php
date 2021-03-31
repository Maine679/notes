<?php

interface IONotesData
{
    public function getCountNotes($userId);
    public function getNote($idNote);
    public function getAllNotes($userId);

    //Записываем в бд или ещё куда то заметку. Передаём её в виде ассоциативного массива.
    // (что бы не привязываться к классу внутри интерфейса)
    public function createNotes($dataNote);

    //первый параметр ид заметки, второй - ассоциативный массив с данными изменяемыми.
    public function editNotes($idNote, $dataNote);
}
