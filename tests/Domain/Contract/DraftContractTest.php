<?php

final class DraftContractTest extends TestCase
{
   public function testBuildingCommand()
   {
       $command = new \FullRent\Core\Contract\DraftContract();

       $this->bus->execute($command);
   }
}