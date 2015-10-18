<?php

namespace Front\GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormStep2
 *
 * @ORM\Table(name="wws_form_step2")
 * @ORM\Entity
 */
class FormStep2
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
     * @ORM\Column(name="universityDegree", type="string", length=255,nullable=true)
     */
    private $universityDegree;

    /**
     * @var string
     *
     * @ORM\Column(name="lastQualification", type="string", length=255,nullable=true)
     */
    private $lastQualification;

    /**
     * @var string
     *
     * @ORM\Column(name="GraduationYear", type="string", length=255,nullable=true)
     */
    private $graduationYear;

    /**
     * @var string
     *
     * @ORM\Column(name="schoolName", type="string", length=255,nullable=true)
     */
    private $schoolName;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255,nullable=true)
     */
    private $country;


    /**
     * @var string
     *
     * @ORM\Column(name="schoolDegree", type="string", length=255,nullable=true)
     */
    private $schoolDegree;

    /**
     * @var string
     *
     * @ORM\Column(name="lastQualificationS2", type="string", length=255,nullable=true)
     */
    private $lastQualificationS2;

    /**
     * @var string
     *
     * @ORM\Column(name="graduationYearS2", type="string", length=255,nullable=true)
     */
    private $graduationYearS2;

    /**
     * @var string
     *
     * @ORM\Column(name="schoolNameS2", type="string", length=255,nullable=true)
     */
    private $schoolNameS2;

    /**
     * @var string
     *
     * @ORM\Column(name="countryS2", type="string", length=255,nullable=true)
     */
    private $countryS2;

    /**
     * @var boolean
     *
     * @ORM\Column(name="englishTest", type="boolean", nullable=true)
     */
    private $englishTest;

    /**
     * @var integer
     *
     * @ORM\Column(name="test", type="integer",nullable=true)
     */
    private $test;

    /**
     * @var string
     *
     * @ORM\Column(name="nameTest", type="string",nullable=true)
     */
    private $nameTest;

    /**
     * @var string
     *
     * @ORM\Column(name="score", type="string",nullable=true)
     */
    private $score;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="testDate", type="date",nullable=true)
     */
    private $testDate;

    /**
     * @ORM\OneToOne(targetEntity="FormStep1", mappedBy="formStep2")
     * */
    private $formStep1;

    /**
     * @ORM\OneToOne(targetEntity="FormStep3", inversedBy="formStep2")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * */
    private $formStep3;

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
     * Set universityDegree
     *
     * @param boolean $universityDegree
     * @return FormStep2
     */
    public function setUniversityDegree($universityDegree)
    {
        $this->universityDegree = $universityDegree;

        return $this;
    }

    /**
     * Get universityDegree
     *
     * @return boolean
     */
    public function getUniversityDegree()
    {
        return $this->universityDegree;
    }

    /**
     * Set lastQualification
     *
     * @param string $lastQualification
     * @return FormStep2
     */
    public function setLastQualification($lastQualification)
    {
        $this->lastQualification = $lastQualification;

        return $this;
    }

    /**
     * Get lastQualification
     *
     * @return string
     */
    public function getLastQualification()
    {
        return $this->lastQualification;
    }

    /**
     * Set graduationYear
     *
     * @param string $graduationYear
     * @return FormStep2
     */
    public function setGraduationYear($graduationYear)
    {
        $this->graduationYear = $graduationYear;

        return $this;
    }

    /**
     * Get graduationYear
     *
     * @return string
     */
    public function getGraduationYear()
    {
        return $this->graduationYear;
    }

    /**
     * Set currentYearStudy
     *
     * @param string $currentYearStudy
     * @return FormStep2
     */
    public function setCurrentYearStudy($currentYearStudy)
    {
        $this->currentYearStudy = $currentYearStudy;

        return $this;
    }

    /**
     * Get currentYearStudy
     *
     * @return string
     */
    public function getCurrentYearStudy()
    {
        return $this->currentYearStudy;
    }

    /**
     * Set schoolName
     *
     * @param string $schoolName
     * @return FormStep2
     */
    public function setSchoolName($schoolName)
    {
        $this->schoolName = $schoolName;

        return $this;
    }

    /**
     * Get schoolName
     *
     * @return string
     */
    public function getSchoolName()
    {
        return $this->schoolName;
    }

    /**
     * Set expectedGraduationYear
     *
     * @param string $expectedGraduationYear
     * @return FormStep2
     */
    public function setExpectedGraduationYear($expectedGraduationYear)
    {
        $this->expectedGraduationYear = $expectedGraduationYear;

        return $this;
    }

    /**
     * Get expectedGraduationYear
     *
     * @return string
     */
    public function getExpectedGraduationYear()
    {
        return $this->expectedGraduationYear;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return FormStep2
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set lastQualificationS2
     *
     * @param string $lastQualificationS2
     * @return FormStep2
     */
    public function setLastQualificationS2($lastQualificationS2)
    {
        $this->lastQualificationS2 = $lastQualificationS2;

        return $this;
    }

    /**
     * Get lastQualificationS2
     *
     * @return string
     */
    public function getLastQualificationS2()
    {
        return $this->lastQualificationS2;
    }

    /**
     * Set graduationYearS2
     *
     * @param string $graduationYearS2
     * @return FormStep2
     */
    public function setGraduationYearS2($graduationYearS2)
    {
        $this->graduationYearS2 = $graduationYearS2;

        return $this;
    }

    /**
     * Get graduationYearS2
     *
     * @return string
     */
    public function getGraduationYearS2()
    {
        return $this->graduationYearS2;
    }

    /**
     * Set schoolNameS2
     *
     * @param string $schoolNameS2
     * @return FormStep2
     */
    public function setSchoolNameS2($schoolNameS2)
    {
        $this->schoolNameS2 = $schoolNameS2;

        return $this;
    }

    /**
     * Get schoolNameS2
     *
     * @return string
     */
    public function getSchoolNameS2()
    {
        return $this->schoolNameS2;
    }

    /**
     * Set countryS2
     *
     * @param string $countryS2
     * @return FormStep2
     */
    public function setCountryS2($countryS2)
    {
        $this->countryS2 = $countryS2;

        return $this;
    }

    /**
     * Get countryS2
     *
     * @return string
     */
    public function getCountryS2()
    {
        return $this->countryS2;
    }

    /**
     * Set englishTest
     *
     * @param boolean $englishTest
     * @return FormStep2
     */
    public function setEnglishTest($englishTest)
    {
        $this->englishTest = $englishTest;

        return $this;
    }

    /**
     * Get englishTest
     *
     * @return boolean
     */
    public function getEnglishTest()
    {
        return $this->englishTest;
    }

    /**
     * Set test
     *
     * @param integer $test
     * @return FormStep2
     */
    public function setTest($test)
    {
        $this->test = $test;

        return $this;
    }

    /**
     * Get test
     *
     * @return integer
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * Set testDate
     *
     * @param \DateTime $testDate
     * @return FormStep2
     */
    public function setTestDate($testDate)
    {
        $this->testDate = $testDate;

        return $this;
    }

    /**
     * Get testDate
     *
     * @return \DateTime
     */
    public function getTestDate()
    {
        return $this->testDate;
    }

    /**
     * Set formStep1
     *
     * @param \Front\GeneralBundle\Entity\FormStep1 $formStep1
     * @return FormStep2
     */
    public function setFormStep1(\Front\GeneralBundle\Entity\FormStep1 $formStep1 = null)
    {
        $this->formStep1 = $formStep1;

        return $this;
    }

    /**
     * Get formStep1
     *
     * @return \Front\GeneralBundle\Entity\FormStep1
     */
    public function getFormStep1()
    {
        return $this->formStep1;
    }

    /**
     * Set formStep3
     *
     * @param \Front\GeneralBundle\Entity\FormStep3 $formStep3
     * @return FormStep2
     */
    public function setFormStep3(\Front\GeneralBundle\Entity\FormStep3 $formStep3 = null)
    {
        $this->formStep3 = $formStep3;

        return $this;
    }

    /**
     * Get formStep3
     *
     * @return \Front\GeneralBundle\Entity\FormStep3
     */
    public function getFormStep3()
    {
        return $this->formStep3;
    }

    public function showUniversityDegree()
    {
        if ($this->universityDegree) return 'Yes'; else
            return 'No';
    }

    public function showEnglishTest()
    {
        if ($this->englishTest) return 'Yes'; else
            return 'No';
    }

    public function showTest()
    {
        if ($this->test == 1) return 'IELTS';
        if ($this->test == 2) return 'TOEFL';
        if ($this->test == 3) return 'OTHER';
    }


    /**
     * Set nameTest
     *
     * @param string $nameTest
     * @return FormStep2
     */
    public function setNameTest($nameTest)
    {
        $this->nameTest = $nameTest;

        return $this;
    }

    /**
     * Get nameTest
     *
     * @return string
     */
    public function getNameTest()
    {
        return $this->nameTest;
    }

    /**
     * Set score
     *
     * @param string $score
     * @return FormStep2
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return string
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set schoolDegree
     *
     * @param string $schoolDegree
     * @return FormStep2
     */
    public function setSchoolDegree($schoolDegree)
    {
        $this->schoolDegree = $schoolDegree;

        return $this;
    }

    /**
     * Get schoolDegree
     *
     * @return string 
     */
    public function getSchoolDegree()
    {
        return $this->schoolDegree;
    }
}
