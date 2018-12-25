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

// new
        $t1=$this->getContainer()->get('dl_commission.law');
        //end new
        $t=$this->getContainer()->get('dl_commission.test');
        $ar = array(/*9069, 9071, 9073, 9074, 9077, 9076, 9081, 9090, 9095, 9101,
  9096, 9082, 9109, 9118, 9119, 9120, 9125, 9148,9149, 9147,
 9168, 9134,9180, 9182, 9086, 9091, 9098,9097,9103, 9105,
 9106, 9107, 9108,9110, 9111, 9112, 9115, 9124, 9126, 9122,
  9113, 9129, 9130, 9131, 9132, 9135, 9136, 9137, 9144, 9146,
            9150, 9151, 9157, 9159, 9161, 9142, 9163, 9164, 9165, 9166,
            9143, 9145, 9169, 9152, 9170, 9171, 9172, 9173, 9162, 9174,
            9175, 9176, 9177, 9178, 9179, 9181, 9183, 9158, 9184, 9185,
            9186, 9187, 9190, 9191, 9192, 9193, 9194, 9195, 9196, 9197,
            9198, 9204, 9205, 9206, 9207, 9208, 9213, 9214, 9216, 9217,
            9219, 9220, 9225, 9227, 9209, 9230, 9234, 9235, 9236, 9233,
            9222, 9231, 9228, 9238, 9240, 9241, 9243, 9244, 9247, 9253,*/
            9233,9222,9231,9228,9237,9238,9239,9240,9241,/*9242,9243,
            9244,9245,9246,9247,9252,9253,9259,9260,9261,9263,9264,
            9265,9266,9267,*/9271,9275,9274/*,9277,9282,9278,9284,9283*/);

       for($i=0;$i<count($ar);$i++) {

           $dispropcom = $t1->getlawezem($ar[$i]);
           var_dump($ar[$i]);
           for ($c = 0; $c < count($dispropcom); $c++) {

               if($dispropcom[$c]->getIdpartenaire()==1767||
               $dispropcom[$c]->getIdpartenaire()==4774){
                   break;
               }
               else {
                  $t->testing($dispropcom[$c], $ar[$i]);

               }
           }
       }


    }
}
