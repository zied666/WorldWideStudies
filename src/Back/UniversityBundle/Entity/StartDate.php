<?php

namespace Back\UniversityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * StartDate
 *
 * @ORM\Table(name="wws_course_title_start_date")
 * @ORM\Entity
 */
class StartDate
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;
    
    /**
     * @ORM\ManyToOne(targetEntity="CourseTitle", inversedBy="startDates")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $courseTitle ;


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
     * Set date
     *
     * @param \DateTime $date
     * @return StartDate
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set courseTitle
     *
     * @param \Back\UniversityBundle\Entity\CourseTitle $courseTitle
     * @return StartDate
     */
    public function setCourseTitle(\Back\UniversityBundle\Entity\CourseTitle $courseTitle = null)
    {
        $this->courseTitle = $courseTitle;

        return $this;
    }

    /**
     * Get courseTitle
     *
     * @return \Back\UniversityBundle\Entity\CourseTitle 
     */
    public function getCourseTitle()
    {
        return $this->courseTitle;
    }
}
