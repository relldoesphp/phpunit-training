<?php
require_once __DIR__ . '/../vendor/autoload.php';

$pdo = new \PDO('sqlite:' . realpath(__DIR__ . '/../data/db/database.db'));
$contactMapper = new \In2it\Phpunit\Model\ContactMapper($pdo);

$contactData = $contactMapper->fetchRow(array ('name' => 'Michelangelo van Dam'));
$contact = new \In2it\Phpunit\Model\Contact($contactData);

$new = new \In2it\Phpunit\Model\Contact();
$new->setName('Chuck Norris');
$new->setEmail('chuck.norris@world.gov');

//$contactMapper->save($new->toArray());

$data = $contactMapper->fetchAll();
foreach ($data as $entry) {
    echo sprintf('%05d | % -25s | % -25s | % 15s', $entry['contact_id'], $entry['name'], $entry['email'], $entry['mobile']) . PHP_EOL;
}