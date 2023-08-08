<?php

namespace App\Command;

use App\Entity\WikiVehicle;
use App\Repository\WikiVehicleRepository;
use App\Service\WorldOfWarShipsEU;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wargaming\Api;
use Wargaming\Language\EN as EnglishLanguage;

#[AsCommand(name: 'wows:download-wiki-vehicles')]
class DownloadWikiVehicles extends Command
{

    private EntityManagerInterface $em;
    private WikiVehicleRepository $vehicleRepository;

    public function __construct(EntityManagerInterface $em, WikiVehicleRepository $vehicleRepository)
    {
        parent::__construct();
        $this->em = $em;
        $this->vehicleRepository = $vehicleRepository;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $lang = new EnglishLanguage();
        $server = new WorldOfWarShipsEU('91720856ee50b4c095e58d5c782ecf47');
        $api = new Api($lang, $server);
        $i=1;
        $break = true;
        while($break) {
            try {
                $data = $api->get('wows/encyclopedia/ships', ['page_no' => $i], true);
                $shipadded = 1;
                foreach ($data as $ship) {
                    if($this->vehicleRepository->findOneBy(['wid' => $ship['ship_id']])) {
                        continue;
                    }
                    $output->writeln(sprintf("[%d-%d]Processing ship [%s]", $i, $shipadded++, $ship['name']));
                    $warship = new WikiVehicle(null, $ship['ship_id'], $ship['name'], $ship['tier'], $ship['type'], $ship['nation']);
                    $this->em->persist($warship);
                    $this->em->flush();
                }
                $i++;
                sleep(1);
            } catch (\Exception $e) {
                $break = false;
            }
        }

        return 0;
    }
}