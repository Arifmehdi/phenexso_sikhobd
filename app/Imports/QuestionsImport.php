<?php

namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuestionsImport implements ToModel, WithHeadingRow
{
    private $userId;

    public function __construct($userId = null)
    {
        $this->userId = $userId;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // CSV Headers: Question,Option_A,Option_B,Option_C,Option_D,Correct_Answer
        // Laravel Excel converts headers to snake_case by default
        
        return new Question([
            'question_text' => trim($row['question']),
            'option_a'      => trim($row['option_a']),
            'option_b'      => trim($row['option_b']),
            'option_c'      => trim($row['option_c']),
            'option_d'      => trim($row['option_d']),
            'correct_option'=> trim(strtolower($row['correct_answer'])),
            'created_by'    => $this->userId,
        ]);
    }
}
