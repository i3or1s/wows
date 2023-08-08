<?php

namespace App\Command;

use App\Repository\PlayerRepository;
use App\Service\WorldOfWarShipsEU;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wargaming\Api;
use Wargaming\Language\EN as EnglishLanguage;

#[AsCommand(name: 'wows:download-player-statistics')]
class DownloadPlayerStatistics extends Command
{
    private EntityManagerInterface $em;
    private PlayerRepository $playerRepository;

    public function __construct(EntityManagerInterface $em, PlayerRepository $playerRepository)
    {
        parent::__construct();
        $this->em = $em;
        $this->playerRepository = $playerRepository;
    }

    protected function configure(): void
    {
        $this
            ->setDefinition([
                new InputArgument('date', InputArgument::REQUIRED, 'Date in format YYYYMMDD'),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $lang = new EnglishLanguage();
        $server = new WorldOfWarShipsEU('91720856ee50b4c095e58d5c782ecf47');
        $api = new Api($lang, $server);

        $allPlayers = $this->playerRepository->findAll();

        /** @var Player $player */
        foreach($allPlayers as $player) {
            $data = $api->get('wows/account/statsbydate', ['account_id' => $player->wid, 'dates' => $input->getArgument('date')], true);
            $listOfPlaysByTheDate = $data[$player->wid]['pvp'];
            foreach ($listOfPlaysByTheDate as $date => $play) {
                // Here goes layer statistics
            }
        }
        return 0;
    }
}