<?php

use PHPUnit\Framework\TestCase;

define("RACINE_UNIT", dirname(__FILE__) . "/../..");
require_once(RACINE_UNIT . '/config_path.php');
require_once(RACINE_UNIT . '/function_test.php');
require_once(RACINE_WWW . '/src/class/pctrconfig/ConfigIni.php');

/**
 * ClassNameTest
 * @group group
 */
class ConfigIniTest extends TestCase
{
    /**
     * @var Create_folder
     */
    protected ConfigIni|null $object;
    private string|null $folderSave;
    private string|null $fileValide;
    private string|null $fileError;
    private string|null $fileVerif;
    private string|null $nameFileValide;
    private string|null $nameFileError;
    private string|null $nameFileVerif;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->folderSave = __DIR__ . "/../../upload/";
        if (!is_dir($this->folderSave)) {
            mkdir($this->folderSave, 0777, true);
        }
        $this->nameFileValide = "ConfigIniValide.txt";
        $this->nameFileError = "ConfigIniError.txt";
        $this->nameFileVerif = "ConfigIniVerif.txt";
        $this->fileValide = $this->folderSave . $this->nameFileValide;
        $this->fileError = $this->folderSave . $this->nameFileError;
        $this->fileVerif = $this->folderSave . $this->nameFileVerif;
        $this->deleteFile();

        $tabError = [];
        $tabVal = [];

        try {
            $this->object = new ConfigIni();
            array_push($tabVal, 'Valeur valide : ' . "");
        } catch (Throwable $th) {
            array_push($tabError, 'Problème : ' . " [" . "" . "] " . $th->getMessage());
        }
        $this->testing($this->object);
        foreach (array_string_all() as $file) {
            try {
                $testobj = new ConfigIni($file);
                array_push($tabVal, 'Valeur valide : ' . $file);
            } catch (Throwable $th) {
                array_push($tabError, 'Problème : ' . " [" . $file . "] " . $th->getMessage());
            }
            $this->testing($testobj);
        }
        $this->displayValidated($tabVal, "ConfigIni", true);
        $this->displayError($tabError, "ConfigIni");
    }

    private function deleteFile(): self
    {
        if (is_file($this->fileValide)) {
            unlink($this->fileValide);
        }
        if (is_file($this->fileError)) {
            unlink($this->fileError);
        }
        if (is_file($this->fileVerif)) {
            unlink($this->fileVerif);
        }
        return $this;
    }

    private function displayValidated(array|null $tabVal, string|null $name = null, bool $verif = false): self
    {
        $name = !empty($name) ? $name : "DATA";
        $tabVal = array_unique($tabVal);
        $content = "------------------------------" . "\n\n";
        $content .= "-- VALIDATED : " . $name . "\n";
        $content .= "------------------------------" . "\n";
        foreach ($tabVal as $value) {
            //echo $value."\n";
            $content .= (!empty($value) ? $value : (isset($value) ? $value : "NULL")) . "\n";
        }
        file_put_contents($this->fileValide, $content, FILE_APPEND);
        if ($verif) {
            file_put_contents($this->fileVerif, $content, FILE_APPEND);
        }
        return $this;
    }

    private function displayError(array|null $tabError, string|null $name = null, bool $verif = false): self
    {
        $name = !empty($name) ? $name : "DATA";
        $tabError = array_unique($tabError);
        $content = "------------------------------" . "\n\n";
        $content .= "-- ERROR : " . $name . "\n";
        $content .= "------------------------------" . "\n";
        foreach ($tabError as $value) {
            //echo $value."\n";
            $content .= (!empty($value) ? $value : (isset($value) ? $value : "NULL")) . "\n";
        }
        file_put_contents($this->fileError, $content, FILE_APPEND);
        if ($verif) {
            file_put_contents($this->fileVerif, $content, FILE_APPEND);
        }
        return $this;
    }

    private function testing($obj): void
    {
        $this->assertNotNull($obj);
        $this->testPathParent();
    }

    public function testPathParent(): void
    {
        $testFunction = $this->object->pathParent();
        $this->assertIsString($testFunction);
        $this->assertNotNull($testFunction);
    }

    public function testFinal(): self
    {
        $folderTest = __DIR__ . "/../../validtest/";
        $txtFileValide = file_get_contents($this->folderSave . $this->nameFileValide);
        $txtFileError = file_get_contents($this->folderSave . $this->nameFileError);
        $txtFileVerif = file_get_contents($this->folderSave . $this->nameFileVerif);
        $txtTstFileValide = file_get_contents($folderTest . $this->nameFileValide);
        $txtTstFileError = file_get_contents($folderTest . $this->nameFileError);
        $txtTstFileVerif = file_get_contents($folderTest . $this->nameFileVerif);
        $this->assertEquals($txtFileValide, $txtTstFileValide);
        $this->assertEquals($txtFileError, $txtTstFileError);
        $this->assertEquals($txtFileVerif, $txtTstFileVerif);
        return $this;
    }

}