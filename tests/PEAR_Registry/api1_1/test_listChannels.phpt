--TEST--
PEAR_Registry->listChannels() (API v1.1)
--SKIPIF--
<?php
if (!getenv('PHP_PEAR_RUNTESTS')) {
    echo 'skip';
}
require_once 'PEAR/Registry.php';
$pv = phpversion() . '';
$av = $pv{0} == '4' ? 'apiversion' : 'apiVersion';
if (!in_array($av, get_class_methods('PEAR_Registry'))) {
    echo 'skip';
}
if (PEAR_Registry::apiVersion() != '1.1') {
    echo 'skip';
}
?>
--FILE--
<?php
error_reporting(E_ALL);
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'setup.php.inc';

$ret = $reg->listChannels();
$phpunit->assertEquals(array('pear.php.net', '__uri'), $ret, 'channels raw');
$ch = new PEAR_ChannelFile;
$ch->setName('test.test.test');
$ch->setAlias('foo');
$ch->setServer('blah');
$ch->setSummary('blah');
$ch->setDefaultPEARProtocols();
$reg->addChannel($ch);
$phpunit->assertNoErrors('setup');

$ret = $reg->listChannels();
$phpunit->assertEquals(array('pear.php.net', 'test.test.test', '__uri'), $ret, 'channels after 1 add');

echo 'tests done';
?>
--EXPECT--
tests done
