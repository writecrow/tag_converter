<?php

namespace writecrow\TagConverter;

use PHPUnit\Framework\TestCase;

/**
 * Test files are converted correctly.
 */
class StructureTest extends TestCase {

  /**
   * Provides data.
   */
  public function dataProvider() {
    return [
      'Traditional' => [
        'filename' => 'file-with-traditional-structure.txt',
        'expected' => '{"Student ID":"10410","Country":"China","Institution":"University of Arizona","Course":"ENGL 106","Mode":"Face to Face","Length":"16 weeks","Assignment":"DE","Draft":"F","Year in School":"1","Gender":"M","Course Year":"2018","Course Semester":"Spring","College":"Colleges Letters Arts Science","Program":"No Major Selected Ltr Art Sci","Proficiency Exam":"TOEFL","Exam total":"73.0","Exam reading":"17.0","Exam listening":"18.0","Exam speaking":"17.0","Exam writing":"21.0","Instructor":"1018","Section":"1039","text":"English:106-005\nUnit1 Project: Description and Explanation\nLanguage Change in my Blog Writing\nWhen the author write about Sociolinguistics, he always write about the variation about language.\n"}',
      ],
      'Single' => [
        'filename' => 'file-with-single-student.txt',
        'expected' => '{"Student IDs":"10527","Group ID":"NA","Institution":"University of Arizona","Course":"ENGL 106","Mode":"Face to Face","Length":"16 weeks","Assignment":"DE","Draft":"F","Course Year":"2019","Course Semester":"Spring","Instructor":"1019","Section":"1057","Student ID":"10527","Country":"NA","L1":"NA","Heritage Spanish Speaker":"NA","Year in School":"1","Gender":"F","College":"Eller College of Management","Program":"Pre-Economics","Proficiency Exam":"TOEFL","Exam total":"85.0","Exam reading":"21.0","Exam listening":"24.0","Exam speaking":"20.0","Exam writing":"20.0","text":"2019-2-19. 10:00am\nAuthor-Spolsky. <name> <name>\nClass section-Eng106\nIn my re-write passage, I followed some rules of the blog and informal writing. Generally, this article is written for myself, so the goal of the rewriting article is to help me better understand this article.\n"}',
      ],
      'Multiple' => [
        'filename' => 'file-with-multiple-students.txt',
        'expected' => '{"Student IDs":["10527","10528"],"Group ID":"NA","Institution":"University of Arizona","Course":"ENGL 106","Mode":"Face to Face","Length":"16 weeks","Assignment":"DE","Draft":"F","Course Year":"2019","Course Semester":"Spring","Instructor":"1019","Section":"1057","Student ID":["10527","10528"],"Country":["NA","CHN"],"L1":["NA","Chinese"],"Heritage Spanish Speaker":["NA","NA"],"Year in School":["1","2"],"Gender":["F","M"],"College":["Eller College of Management","School B"],"Program":["Pre-Economics","English"],"Proficiency Exam":["TOEFL","TOEFL"],"Exam total":["85.0","89.0"],"Exam reading":["21.0","22.0"],"Exam listening":["24.0","25.0"],"Exam speaking":["20.0","21.0"],"Exam writing":["20.0","21.0"],"text":"2019-2-19. 10:00am\nAuthor-Spolsky. <name> <name>\nClass section-Eng106\nIn my re-write passage, I followed some rules of the blog and informal writing. Generally, this article is written for myself, so the goal of the rewriting article is to help me better understand this article.\n"}',
      ],
    ];
  }

  /**
   * Test assertions.
   *
   * @dataProvider dataProvider
   */
  public function testStructure($filename, $expected) {
    $input = file_get_contents('test/data/' . $filename, FILE_USE_INCLUDE_PATH);
    $actual = TagConverter::json($input);
    $this->assertEquals($expected, html_entity_decode($actual));
  }

}
