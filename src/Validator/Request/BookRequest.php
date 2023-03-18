<?php

namespace App\Validator\Request;

use Symfony\Component\Validator\Constraints as Assert;

class BookRequest extends ValidatedRequest
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    private $name;

    /**
     * @Assert\Type("int")
     * @Assert\Range(
     *     min = 1,
     *     max = 5000
     * )
     */
    private $pageCount = 400;

    /**
     * @Assert\NotNull()
     * @Assert\Type("bool")
     */
    private $isActive;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPageCount()
    {
        return $this->pageCount;
    }

    /**
     * @param mixed $pageCount
     */
    public function setPageCount($pageCount): void
    {
        $this->pageCount = $pageCount;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive): void
    {
        $this->isActive = $isActive;
    }
}
