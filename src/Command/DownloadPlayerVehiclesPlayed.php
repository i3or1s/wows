<?php

namespace App\Command;

use App\Entity\Player;
use App\Entity\PlayerVehiclesPlayed;
use App\Repository\PlayerRepository;
use App\Repository\WikiVehicleRepository;
use App\Service\WorldOfWarShipsEU;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wargaming\Api;
use Wargaming\Language\EN as EnglishLanguage;

#[AsCommand(name: 'wows:download-player-vehicles-played')]
class DownloadPlayerVehiclesPlayed extends Command
{
    private EntityManagerInterface $em;
    private PlayerRepository $playerRepository;
    private WikiVehicleRepository $wikiVehicle;

    public function __construct(EntityManagerInterface $em, PlayerRepository $playerRepository, WikiVehicleRepository $wikiVehicle)
    {
        parent::__construct();
        $this->em = $em;
        $this->playerRepository = $playerRepository;
        $this->wikiVehicle = $wikiVehicle;
    }

    protected function configure(): void
    {
//        $this
//            ->setDefinition([
//                new InputArgument('date', InputArgument::REQUIRED, 'Date in format YYYYMMDD'),
//            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $lang = new EnglishLanguage();
        $server = new WorldOfWarShipsEU('91720856ee50b4c095e58d5c782ecf47');
        $api = new Api($lang, $server);

        $allPlayers = $this->playerRepository->findAll();

        /** @var Player $player */
        foreach($allPlayers as $player) {
            $data = $api->get('wows/ships/stats', ['account_id' => $player->wid], true);
            foreach ($data[$player->wid] as $play) {
                $pvp = $play['pvp'];
                $vehicle = $this->wikiVehicle->findOneBy(['wid' => $play['ship_id']]);
                if(!$vehicle) {
                    // Skip non existent vehicle
                    $output->writeln('Vehicle non existent [%s]', $play['ship_id']);
                    continue;
                }
                $entity = new PlayerVehiclesPlayed(null, $player, $vehicle, $pvp['battles'], $pvp['damage_dealt'], $pvp['xp'], $pvp['wins'], $pvp['frags'], '', '');
                $this->em->persist($entity);
                $this->em->flush();
            }

        }
        return 0;
    }
}