<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;

#[AsCommand(
    name: 'app:productChangeStatus',
    description: 'Add a short description for your command',
)]
class ProductChangeStatusCommand extends Command
{
    private $manager;
    
    public function __construct(EntityManagerInterface $manager)
    {
        parent::__construct();
        $this->manager = $manager;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('check', null, InputOption::VALUE_NONE, 'Check all status')
            ->addOption('changeNew', null, InputOption::VALUE_NONE, 'change status new->old')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);


        if ($input->getOption('check')) {
            $products = $this->manager->getRepository(Product::class)->findAll();
            $productCount = count($products);
            $io->writeln('<info>----------------------------------</info>');
            $io->writeln('<info>'.$productCount.' Produits dans la base de données! </info>');
            $io->writeln('<info>----------------------------------</info>');
        }

        if($input->getOption('changeNew')){
            $newProducts = $this->manager->getRepository(Product::class)->findBy(['isNewArrival' => true]);
            $newProductsCount = count($newProducts);
            
            foreach($newProducts as $newProduct)
            {
                $newProduct->setIsNewArrival(false);
                $this->manager->persist($newProduct);
                $this->manager->flush();
            }

            $io->writeln('<info>-------------------------------------------</info>');
            $io->writeln('<info>------'.$newProductsCount.' Nouveaux produits ont été changés  dans la base de données ---------</info>');
            $io->writeln('<info>-------------------------------------------</info>');
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
