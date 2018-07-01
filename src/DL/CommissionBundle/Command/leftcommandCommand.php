<?php

namespace DL\CommissionBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class leftcommandCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('dlcommission:leftcommand_command')
            ->addArgument('id', InputArgument::REQUIRED, 'Who do you id?')
            ->setDescription('Hello PhpStorm');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ids = $input->getArgument('id');
        $t1=$this->getContainer()->get('dl_commission.partner');
        $t1->getrightpartner($ids);
        $output->write($ids);
        $output->write('aaaaaaaa');



    }
}
