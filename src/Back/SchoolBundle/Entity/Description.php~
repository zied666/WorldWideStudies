<?php

namespace Back\SchoolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description
 *
 * @ORM\Table(name="wws_description")
 * @ORM\Entity
 */
class Description
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    
    /**
     * @ORM\ManyToOne(targetEntity="CourseSubject", inversedBy="descriptions")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $courseSubject;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Description
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Description
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set courseSubject
     *
     * @param \Back\SchoolBundle\Entity\CourseSubject $courseSubject
     * @return Description
     */
    public function setCourseSubject(\Back\SchoolBundle\Entity\CourseSubject $courseSubject = null)
    {
        $this->courseSubject = $courseSubject;

        return $this;
    }

    /**
     * Get courseSubject
     *
     * @return \Back\SchoolBundle\Entity\CourseSubject 
     */
    public function getCourseSubject()
    {
        return $this->courseSubject;
    }
}
