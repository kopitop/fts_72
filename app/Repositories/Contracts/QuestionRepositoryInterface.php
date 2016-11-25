<?php  

namespace App\Repositories\Contracts;

interface QuestionRepositoryInterface extends RepositoryInterface
{
    /**
     * Store a new question in repository
     *
     * @throws Exception
     *
     * @param array $input
     *
     * @return mixed
     */
    public function storeQuestion(array $input);

    /**
     * Update a question in repository
     *
     * @throws Exception
     *
     * @param array $input
     *
     * @param int $id
     *
     * @return mixed
     */
    public function updateQuestion(array $input, $id);
}
