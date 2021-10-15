<?php
//// create_product.php <name>
//require "app/dependencies.php";
////use Doctrine\ORM\EntityManager;
//// bootstrap.php
//use Doctrine\ORM\Tools\Setup;
//use Doctrine\ORM\EntityManager;
//
//require_once "vendor/autoload.php";
//
//// Create a simple "default" Doctrine ORM configuration for Annotations
//$isDevMode = true;
//$proxyDir = null;
//$cache = null;
//$useSimpleAnnotationReader = false;
//$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);
//// or if you prefer yaml or XML
////$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
////$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);
//
//// database configuration parameters
//$conn = array(
//    'driver' => 'pdo_mysql',
//    'host' => 'db',
//    'port' => 3306,
//    'dbname' => 'projet_covid',
//    'user' => 'user',
//    'password' => 'user',
//    'charset' => 'utf8'
//);
//
//// obtaining the entity manager
//$entityManager = EntityManager::create($conn, $config);
////use App\Entity\Testbdd;
//
//
//
//function test(EntityManager $em)
//{
//    $newProductName = 1;
//    echo "ok";
//    $product = new \App\Entity\Geolocalisation();
//    $product->setLatitude(48.680488);
//    $product->setLongitude(6.153333);
//
//    $em->persist($product);
//    $em->flush();
//
//    echo "Created Product with ID " . $product->getId() . "\n";
//}
//test($entityManager);
