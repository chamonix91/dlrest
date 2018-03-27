<?php

namespace DL\CommissionBundle\Command;

use DL\BackofficeBundle \Entity\Revenu;
use DL\CommissionBundle\Controller\RevenueController;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Console\Input\InputArgument;

class RemunirationCommand extends ContainerAwareCommand
{
    /**
     * @var EntityManager
     */
    protected $em;
    /**
     * @var EntityRepository
     */
    protected $repo;

    public function setEntityManager(EntityManager $em) {
        $this->em = $em;
        $this->repo = null;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('dlcommission:remuniration_command')
             ->addArgument('id', InputArgument::REQUIRED, 'Who do you id?')
            ->setDescription('Hello PhpStorm');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Whoa!');
        $ids = $input->getArgument('id');

        //$this->get('dreamlife_partner.earning_manager');
        $t=$this->getContainer()->get('dl_commission.test');
        //$t->testing(12);
        $t->testing($ids);



    }
}
