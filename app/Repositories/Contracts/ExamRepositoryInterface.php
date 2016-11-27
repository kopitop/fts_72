<?php  

namespace App\Repositories\Contracts;

interface ExamRepositoryInterface extends RepositoryInterface
{
    /**
     * Store all data of a exam
     *
     * @param array $input
     *
     * @return mixed
     */
    public function storeExam($input);

    /**
     * Get all data exams of a user
     *
     * @return mixed
     */
    public function getExamsOfUser();

    /**
     * Get data of a exam
     *
     * @param int $id
     *
     * @return mixed
     */
    public function showExam($id);

    /**
     * Save data of a exam
     *
     * @param int $id, array $data
     *
     * @return mixed
     */
    public function saveExam($data, $id);

}
