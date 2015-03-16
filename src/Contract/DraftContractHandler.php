<?php
namespace FullRent\Core\Contract;

use FullRent\Core\CommandBus\CommandHandler;


final class DraftContractHandler implements CommandHandler
{

    public function handle(DraftContract $draftContract)
    {
        dd($draftContract);
    }
}