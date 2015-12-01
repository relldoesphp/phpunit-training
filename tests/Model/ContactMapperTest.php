<?php
namespace In2it\Test\Phpunit\Model;

use Faker\Factory;
use In2it\Phpunit\Model\Contact;
use In2it\Phpunit\Model\ContactMapper;

class ContactMapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Generates random data collections to use in our application
     *
     * @param int $totalEntries
     * @return array
     */
    protected function generateCollection($totalEntries = 0)
    {
        $faker = Factory::create();
        $collection = array ();
        for ($i = 0; $i < $totalEntries; $i++) {
            $collection[] = array (
                'contact_id' => $faker->randomDigitNotNull,
                'name'       => $faker->name,
                'address'    => $faker->address,
                'zip'        => $faker->postcode,
                'city'       => $faker->city,
                'country'    => $faker->countryCode,
                'email'      => $faker->email,
                'phone'      => $faker->phoneNumber,
                'mobile'     => $faker->phoneNumber,
            );
        }
        return $collection;
    }

    /**
     * Generates a single entry to use as contact
     *
     * @param bool|false $newEntry
     * @return \stdClass
     */
    public function generateEntry($newEntry = false)
    {
        $faker = Factory::create();
        $entry = new \stdClass();
        $entry->contact_id = ($newEntry ? 0 : $faker->numberBetween(1, 200000));
        $entry->name = $faker->name;
        $entry->address = $faker->address;
        $entry->zip = $faker->postcode;
        $entry->city = $faker->city;
        $entry->country = $faker->countryCode;
        $entry->email = $faker->email;
        $entry->phone = $faker->phoneNumber;
        $entry->mobile = $faker->phoneNumber;
        return $entry;
    }

    /**
     * Generates a Mocked PDO Object that will prepare statements
     * and returns given values.
     *
     * @param array $methodValues
     * @return \PDO
     */
    protected function generateMockPDO(array $methodValues = array ())
    {
        $stmtMethods = array_keys($methodValues);
        $pdoStmt = $this->getMockBuilder('\\PDOStatement')
            ->setMethods($stmtMethods)
            ->getMock();
        foreach ($methodValues as $method => $value) {
            $pdoStmt->method($method)
                ->will($this->returnValue($value));
        }
        $pdo = $this->getMockBuilder('\\PDO')
            ->setMethods(array ('prepare'))
            ->setConstructorArgs(array ('sqlite::memory:'))
            ->getMock();
        $pdo->method('prepare')
            ->will($this->returnValue($pdoStmt));
        return $pdo;
    }

    /**
     * @covers \In2it\Phpunit\Model\ContactMapper::fetchAll
     */
    public function testFetchingAllContacts()
    {
        $dataCount = 4;
        $testData = $this->generateCollection($dataCount);
        $pdo = $this->generateMockPDO(array ('fetchAll' => $testData));

        // Ready to test the logic
        $contactMapper = new ContactMapper($pdo);
        $result = $contactMapper->fetchAll();
        $this->assertCount($dataCount, $result);
        for ($i = 0; $i < $dataCount; $i++) {
            $this->assertSame($testData[$i], $result[$i]);
        }
    }

    /**
     * @covers \In2it\Phpunit\Model\ContactMapper::save
     */
    public function testInsertingNewContact()
    {
        $testData = $this->generateEntry(true);
        $pdo = $this->generateMockPDO(array ('execute' => true));

        $contact = new Contact($testData);
        $contactMapper = new ContactMapper($pdo);
        $result = $contactMapper->save($contact->toArray());
        $this->assertTrue($result);
    }

    /**
     * @covers \In2it\Phpunit\Model\ContactMapper::save
     */
    public function testUpdatingExistingContact()
    {
        $testData = $this->generateEntry(false);
        $pdo = $this->generateMockPDO(array ('execute' => true));

        $contact = new Contact($testData);
        $contactMapper = new ContactMapper($pdo);
        $result = $contactMapper->save($contact->toArray());
        $this->assertTrue($result);
    }
}