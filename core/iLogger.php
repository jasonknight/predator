<?php
namespace Codeable;
interface iLogger {
  public function SetID($id);
  public function GetID();
  public function Info(...$params);
  public function Error(...$params);
  public function Debug(...$params);
  public function LastLine();
  public function LastLines($n);
  public function Lines();
  public function SetMaxLinesKept($n);
  public function GetMaxLinesKept();
  public function GetLineCount();
  public function AddLine($type,$params);
  public function UnshiftLine();
  public function Save();
  public function Load();
  public function WordPressInit();
}