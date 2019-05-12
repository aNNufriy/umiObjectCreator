<?php
 header("Content-type: text/html; charset=utf-8");

 include "/var/www/prof/public_html/standalone.php";

 /**
 * create object of predefined type
 * @param int $DOCUMENT_OBJECT_TYPE_ID
 * @param String $NAME
 * @return umiObject created object
 */
 function createObject($DOCUMENT_OBJECT_TYPE_ID,$NAME) {
   $objects = umiObjectsCollection::getInstance();
   $objectId = $objects->addObject($NAME, $DOCUMENT_OBJECT_TYPE_ID);
   return $objects->getObject($objectId);
 }

 /**
 * create fileProperty and associate it with the object
 * @param umiObject $object - new fileProperty will be set for this object
 * @param String $path - path to file
 */
 function addFileValue($object,$path){
   $property = $object->getPropByName("fajl_dokumenta");
   $property->setValue(new umiFile($path));
   $object->commit();
 }

 /**
 * create page, for object representation
 * @param String $parentElementPath - section to add page to
 * @param umiObject $object - object to be associated with a new page
 * @param String $NAME - a name for the page being created
 * @return int $newPageId
 */
 function createPage($parentElementPath, $object, $NAME){
   $hierarchyTypes = umiHierarchyTypesCollection::getInstance();
   $contentHierarchyType = $hierarchyTypes->getTypeByName("content", "page");
   $contentHierarchyTypeId = $contentHierarchyType->getId();

   $hierarchy = umiHierarchy::getInstance();
   $parentElementId = $hierarchy->getIdByPath($parentElementPath);
   $newPageId = $hierarchy->addElement($parentElementId,$contentHierarchyTypeId,$NAME,false);
   $newPage = $hierarchy->getElement($newPageId);
   $newPage->setObject($object);
   $newPage->setIsActive();
   $newPage->commit();
   return $newPageId;
 }

 $DOCUMENT_OBJECT_TYPE_ID = 1111;
 $NAME = "ZZZ";
 $path = "/var/www/site/files/file.jpg";
 $SECTION_NAME = "section/page_static_adr";

 $object = createObject($DOCUMENT_OBJECT_TYPE_ID, $NAME);
 addFileValueToObject($object, $path);
 createPage($SECTION_NAME, $object, $NAME);

?>
