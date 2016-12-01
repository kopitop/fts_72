<?php

return [

    'errors' => [
        'create' => 'Failed to create a record in database due to a system error.',
        'update' => 'Failed to update a record in database due to a system error.',
        'delete' => 'Failed to delete a record in database due to a system error.',
        'create-exam' => 'Failed to initialize your exam',
        'check' => 'The exam could not be checked',
        'checked' => 'The exam has already be checked',
    ],
    'success' => [
        'create' => 'Created successfully!',
        'update' => 'Updated successfully!',
        'delete' => 'Delete successfully!',
        'save-exam' => 'Your exam has been saved',
        'create-exam' => 'Your exam has been initialized',
        'check' => 'The exam has been checked',
    ],
    'empty' => [
        'update' => 'You tried to update an in-use question',
    ],
    'validator' => [
        'answer' => [
            'max' => 'The answer  :key must be less than :max characters.',
            'required' => 'The answer  :key must be required',
        ],
    ],
    'create-exam' => 'Your exam has been initialized',
    'load-page' => 'Beware!!! You can lost your progress! Are you sure to leave?',
    'exam-checked' => 'The exam of :user has been checked done. Score: :score',
];
