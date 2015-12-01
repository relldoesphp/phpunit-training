<?php
namespace In2it\Test\Phpunit\Model;

use In2it\Phpunit\Model\ContactMapper;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use PHPUnit_Extensions_Database_DB_IDatabaseConnection;

class ContactMapperTest extends \PHPUnit_Extensions_Database_TestCase
{
    /**
     * @var \PDO The PHP Data Object
     */
    protected $pdo;

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        $pdo = new \PDO('sqlite::memory:');
        $pdo->exec(file_get_contents(__DIR__ . '/../../data/db/ddl.sqlite.sql'));
        $this->pdo = $pdo;
    }

    /**
     * Returns the test database connection.
     *
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    protected function getConnection()
    {
        return $this->createDefaultDBConnection($this->pdo, ':memory:');
    }

    /**
     * Returns the test dataset.
     *
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        return $this->createFlatXMLDataSet(__DIR__ . '/_files/initial-dataset.xml');
    }

    /**
     * Custom functionality to convert resultsets to XML DataSets to
     * be used with DBUnit.
     *
     * @param array $data
     * @param string $table
     * @return \PHPUnit_Extensions_Database_DataSet_FlatXmlDataSet
     */
    protected function parseXmlDataSet($data, $table)
    {
        $filename = __DIR__ . '/_files/tmp-dataset.xml';

        $xml = new \DOMDocument('1.0', 'UTF-8');
        $datasetNode = $xml->createElement('dataset');

        foreach ($data as $row) {
            $entry = $xml->createElement($table);
            foreach ($row as $key => $value) {
                $entry->setAttribute($key, htmlentities($value, ENT_QUOTES, 'utf-8'));
            }
            $datasetNode->appendChild($entry);
        }
        $xml->appendChild($datasetNode);
        $xml->save($filename);
        $dataSet = $this->createFlatXMLDataSet($filename);
        unlink ($filename);
        return $dataSet;
    }

    /**
     * @covers In2it\Phpunit\Model\ContactMapper::fetchAll
     */
    public function testFetchAllRowsFromContact()
    {
        // Let's count entries from our database
        $expectedCount = $this->getConnection()->getRowCount('contact');

        // Now we use our logic to retrieve the data from the database
        $contactMapper = new ContactMapper($this->pdo);
        $result = $contactMapper->fetchAll();

        // We verify we have the same row count
        $actualCount = count($result);
        $this->assertSame($expectedCount, $actualCount);

        // Let's verify the data matches
        $actualDataSet = $this->parseXMLDataSet($result, 'contact');
        $expectedDataSet = $this->createFlatXMLDataSet(__DIR__ . '/_files/fetchall-dataset.xml');
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
    }

}