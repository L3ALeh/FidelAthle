<?php
use App\Entity\Course;
use App\Entity\NiveauCourse;
use App\Entity\TypeCourse;
use App\Entity\User;
use App\Entity\ResultatCourse;
use PHPUnit\Framework\TestCase;

class CourseUtilTest extends TestCase
{
    private Course $course;
    private NiveauCourse $niveau;
    private TypeCourse $type;
    private User $organisateur;
    private ResultatCourse $resultat;

    protected function setUp(): void
    {
        $this->course = new Course();
        $this->niveau = new NiveauCourse();
        $this->type = new TypeCourse();
        $this->organisateur = new User();
        $this->resultat = new ResultatCourse();
    }

    public function testSetEtGetNomCourse()
    {
        $this->assertNull($this->course->getNomCourse());

        $this->course->setNomCourse("Course test");

        $this->assertEquals("Course test", $this->course->getNomCourse());
    }

    public function testSetEtGetDistance()
    {
        $this->assertNull($this->course->getDistance());

        $this->course->setDistance(10.5);

        $this->assertEquals(10.5, $this->course->getDistance());
    }

    public function testSetEtGetPrix()
    {
        $this->assertNull($this->course->getPrix());

        $this->course->setPrix(20.0);

        $this->assertEquals(20.0, $this->course->getPrix());
    }

    public function testSetEtGetDate()
    {
        $date = new \DateTime();

        $this->assertNull($this->course->getDate());

        $this->course->setDate($date);

        $this->assertEquals($date, $this->course->getDate());
    }

    public function testSetEtGetUnNiveauCourse()
    {
        $this->assertNull($this->course->getUnNiveauCourse());

        $this->course->setUnNiveauCourse($this->niveau);

        $this->assertEquals($this->niveau, $this->course->getUnNiveauCourse());
    }

    public function testSetEtGetUnTypeCourse()
    {
        $this->assertNull($this->course->getUnTypeCourse());

        $this->course->setUnTypeCourse($this->type);

        $this->assertEquals($this->type, $this->course->getUnTypeCourse());
    }

    public function testGetLesResultatsCourses()
    {
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $this->course->getLesResultatsCourses());
    }

    public function testAjouterEtEnleverLesResultatsCourse()
    {
        $this->assertCount(0, $this->course->getLesResultatsCourses());

        $this->course->addLesResultatsCourse($this->resultat);

        $this->assertCount(1, $this->course->getLesResultatsCourses());

        $this->course->removeLesResultatsCourse($this->resultat);

        $this->assertCount(0, $this->course->getLesResultatsCourses());
    }

    public function testSetEtGetUnOrganisateur()
    {
        $this->assertNull($this->course->getUnOrganisateur());

        $this->course->setUnOrganisateur($this->organisateur);

        $this->assertEquals($this->organisateur, $this->course->getUnOrganisateur());
    }
}
?>