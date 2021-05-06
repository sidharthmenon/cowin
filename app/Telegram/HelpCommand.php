<?php

namespace App\Telegram;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

/**
 * Class HelpCommand.
 */
class HelpCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'help';

    /**
     * @var string Command Description
     */
    protected $description = 'Help command, Get a list of commands';

    /**
     * {@inheritdoc}
     */
    public function handle($arguments)
    {
        $commands = $this->telegram->getCommands();

        $text = '';
        foreach ($commands as $name => $handler) {
            $text .= sprintf('/%s - %s'.PHP_EOL, $name, $handler->getDescription());
        }

        
        $text .= PHP_EOL;
        $text .= 'Disclaimer: This bot utilises [Co-WIN Public APIs](https://apisetu.gov.in/public/marketplace/api/cowin/cowin-public-v2#/) to provide the information. All information provided by this bot is derived directly from the Co-WIN Public APIs.';
        $text .= PHP_EOL;
        $text .= PHP_EOL;
        $text .= "Bot developed by [Sidharth Menon](https://in.linkedin.com/in/isidharth)";

        $this->replyWithMessage(['text' => $text, 'parse_mode' => 'Markdown']);
    }
}
