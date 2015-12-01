<?php
namespace In2it\Test\Phpunit\Model;

use In2it\Phpunit\Model\Contact;
use In2it\Phpunit\Model\ContactMapper;

class ContactMapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \In2it\Phpunit\Model\ContactMapper::fetchAll
     */
    public function testFetchingAllContacts()
    {
        $testData = array (
            array (
                'contact_id' => 1,
                'name'       => 'Foo',
                'address'    => 'Foo Bar 123',
                'zip'        => '12345',
                'city'       => 'Baz',
                'country'    => 'AN',
                'email'      => 'foo@bar.baz',
                'phone'      => '+1234567890',
                'mobile'     => '+9876543210',
            ),
            array (
                'contact_id' => 2,
                'name'       => 'Tik',
                'address'    => 'Tik Tak 456',
                'zip'        => '1000',
                'city'       => 'Tok',
                'country'    => 'ZG',
                'email'      => 'tik.tak@een.be',
                'phone'      => '+1234567890',
                'mobile'     => '+9876543210',
            ),
        );
        // Let's mock our statements first
        $pdoStmt = $this->getMockBuilder('\\PDOStatement')
            ->setMethods(array ('fetchAll'))
            ->getMock();
        $pdoStmt->method('fetchAll')
            ->will($this->returnValue($testData));
        // Now we can mock PDO itself
        $pdo = $this->getMockBuilder('\\PDO')
            ->setConstructorArgs(array ('sqlite::memory:'))
            ->setMethods(array ('prepare', 'fetchAll'))
            ->getMock();
        $pdo->method('prepare')
            ->will($this->returnValue($pdoStmt));

        // Ready to test the logic
        $contactMapper = new ContactMapper($pdo);
        $result = $contactMapper->fetchAll();
        $this->assertCount(2, $result);
        $this->assertSame($testData[0], $result[0]);
        $this->assertSame($testData[1], $result[1]);
    }

    /**
     * @covers \In2it\Phpunit\Model\ContactMapper::save
     */
    public function testInsertingNewContact()
    {
        $testData = new \stdClass();
        $testData->contact_id = 1;
        $testData->name = 'Foo';
        $testData->address = 'Foo Bar 123';
        $testData->zip = '12345';
        $testData->city = 'Baz';
        $testData->country = 'AN';
        $testData->email = 'foo@bar.baz';
        $testData->phone = '+1234567890';
        $testData->mobile = '+9876543210';

        $pdoStmt = $this->getMockBuilder('\\PDOStatement')
            ->setMethods(array ('execute'))
            ->getMock();
        $pdoStmt->method('execute')
            ->will($this->returnValue(true));
        $pdo = $this->getMockBuilder('\\PDO')
            ->setMethods(array ('prepare'))
            ->setConstructorArgs(array ('sqlite::memory:'))
            ->getMock();
        $pdo->method('prepare')
            ->will($this->returnValue($pdoStmt));

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
        $testData = new \stdClass();
        $testData->contact_id = 1;
        $testData->name = 'Foo';
        $testData->address = 'Foo Bar 123';
        $testData->zip = '12345';
        $testData->city = 'Baz';
        $testData->country = 'AN';
        $testData->email = 'foo@bar.baz';
        $testData->phone = '+1234567890';
        $testData->mobile = '+9876543210';

        $pdoStmt = $this->getMockBuilder('\\PDOStatement')
            ->setMethods(array ('execute'))
            ->getMock();
        $pdoStmt->method('execute')
            ->will($this->returnValue(true));
        $pdo = $this->getMockBuilder('\\PDO')
            ->setMethods(array ('prepare'))
            ->setConstructorArgs(array ('sqlite::memory:'))
            ->getMock();
        $pdo->method('prepare')
            ->will($this->returnValue($pdoStmt));

        $contact = new Contact($testData);
        $contactMapper = new ContactMapper($pdo);
        $result = $contactMapper->save($contact->toArray());
        $this->assertTrue($result);
    }
}