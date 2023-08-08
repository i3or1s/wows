<?php

namespace App\Command;

use App\Entity\Player;
use App\Repository\PlayerRepository;
use App\Service\WorldOfWarShipsEU;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wargaming\Api;
use Wargaming\Language\EN as EnglishLanguage;

#[AsCommand(name: 'wows:download-players')]
class DownloadPlayers extends Command
{
    private EntityManagerInterface $em;
    private PlayerRepository $playerRepository;

    public function __construct(EntityManagerInterface $em, PlayerRepository $playerRepository)
    {
        parent::__construct();
        $this->em = $em;
        $this->playerRepository = $playerRepository;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $lang = new EnglishLanguage();
        $server = new WorldOfWarShipsEU('91720856ee50b4c095e58d5c782ecf47');
        $api = new Api($lang, $server);

        $data = $api->get('wows/account/info', ['account_id' => '502670355'], true);
        foreach ($data as $ship) {
            if($this->playerRepository->findOneBy(['wid' => $ship['account_id']])) {
                continue;
            }
            $player = new Player(null, $ship['account_id'], $ship['nickname'], 'eu');
            $this->em->persist($player);
            $this->em->flush();
        }
        sleep(1);

        return 0;
    }
}