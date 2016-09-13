<?php
// src/AppBundle/BulkFileHandler.php
namespace AppBundle;

use AppBundle\Entity\BulkFile;
use AppBundle\Entity\Inquiry;
use AppBundle\Entity\Person;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class BulkFileHandler
{

  protected $em;
  private $targetDir;

  public function __construct($targetDir, EntityManager $entityManager)
  {
    $this->targetDir = $targetDir;
    $this->em = $entityManager;
  }

  public function upload(UploadedFile $file)
  {
    $fileName = md5(uniqid()) . '.' . $file->guessExtension();

    $file->move($this->targetDir, $fileName);

    return $fileName;
  }

  public function process(BulkFile $file)
  {
    $myFile = null;

    try {
      $myFile = fopen($this->targetDir . '/' . $file->getFilePath(), "r");
      $map = json_decode($file->getColumnMapping());
      $identity = empty($map->nic);

      if ($file->getHeaders() == true) {
        fgetcsv($myFile);   // skip header
      }

      while (!feof($myFile)) {
        $values = fgetcsv($myFile);

        if(empty($values)) {break;}
        array_unshift($values, "tmp");  // make 1-based array

        // Create new person or get existing.
        $person = null;
        if (!$identity && !empty($values[$map->nic])) {
          $records = $this->em->getRepository("AppBundle:Person")->findOneBy(array("nic" => $values[$map->nic]));
          if (!is_null($records)) {
            $person = $records;
          } else {
            $person = $this->createPerson($values, $map);
          }
        } else {
          $person = $this->createPerson($values, $map);
        }

        // Create new inquiry
        $inquiry = new Inquiry();
        $inquiry->setPerson($person);

        $inquiryStatus = $this->em->getRepository("AppBundle:InquiryStatus")->findOneBy(array('name' => "Unassigned"));
        if (!is_null($inquiryStatus)) {
          $inquiry->setInquiryStatus($inquiryStatus);
        }
        $inquiryMode = $this->em->getRepository("AppBundle:InquiryMode")->findOneBy(array('name' => "Bulk"));
        if (!is_null($inquiryMode)) {
          $inquiry->setInquiryMode($inquiryMode);
        }
        if (!empty($map->courseCode)) {
          $course = $this->em->getRepository("AppBundle:Course")->findOneBy(array('code' => $values[$map->courseCode]));
          if (!is_null($course)) {
            $inquiry->setCourse($course);
          }
        } elseif (!empty($map->courseName)) {
          $course = $this->em->getRepository("AppBundle:Course")->findOneBy(array('name' => $values[$map->courseName]));
          if (!is_null($course)) {
            $inquiry->setCourse($course);
          }
        }

        $inquiry->setLastModified(new \DateTime("now"));
        $inquiry->setCreated(new \DateTime("now"));
        $inquiry->setProbability(0);

        $this->em->persist($inquiry);
      }

      $this->em->flush();
    } catch (Exception $e) {
      return false;
    } finally {
      fclose($myFile);
    }

    return true;
  }

  private function createPerson($values, $mapping) {
    $person = new Person();

    if (!empty($mapping->nic)) { $person->setNic($values[$mapping->nic]);}
    if (!empty($mapping->name)) { $person->setName($values[$mapping->name]);} else {$person->setName("nameNotMappedProperly");}
    if (!empty($mapping->telephone)) { $person->setTelephone($values[$mapping->telephone]);}
    if (!empty($mapping->email)) { $person->setEmail($values[$mapping->email]);}
    if (!empty($mapping->school)) { $person->setSchool($values[$mapping->school]);}
    // if (!empty($mapping->dob)) { $person->setDob($values[$mapping->dob]);}  // @todo format

    if (!empty($mapping->olEnglish)) { $person->setOlEnglish($values[$mapping->olEnglish]);}
    if (!empty($mapping->olMath)) { $person->setOlMaths($values[$mapping->olMath]);}
    if (!empty($mapping->lang)) { $person->setLanguage($values[$mapping->lang]);}
    // if (!empty($mapping->alGrades)) { $person->setAlGrades($values[$mapping->alGrades]);}  // @todo format
    // if (!empty($mapping->freeTime)) { $person->setAvailableTime($values[$mapping->freeTime]);}  // @todo format
    if (!empty($mapping->work)) { $person->setWorkExperience($values[$mapping->work]);}
    if (!empty($mapping->education)) { $person->setEduQualification($values[$mapping->education]);}

    // @todo format
    if (!empty($mapping->street1)) { $person->setStreet1($values[$mapping->street1]);}
    if (!empty($mapping->street2)) { $person->setStreet2($values[$mapping->street2]);}
    if (!empty($mapping->city)) { $person->setCity($values[$mapping->city]);}
    if (!empty($mapping->district)) { $person->setDistrict($values[$mapping->district]);}

    if (!empty($mapping->description)) { $person->setDescription($values[$mapping->description]);}

    $this->em->persist($person);

    return $person;
  }
} 