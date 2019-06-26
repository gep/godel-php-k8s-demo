<?php


namespace App\Command;


use App\Services\Goods\GoodsService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateGoodsCommand extends Command
{
    /** @var GoodsService */
    protected $goodsService;

    protected static $defaultName = 'app:create-goods';

    public function __construct(GoodsService $userManager)
    {
        $this->goodsService = $userManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates new goods.')
            ->addArgument('amount', InputArgument::REQUIRED, 'Goods amount')
            ->setHelp('This command allows you to create new goods...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Goods Creator',
            '============',
            '',
        ]);

        $output->writeln(
            sprintf(
                '%d goods successfully generated!',
                $this->goodsService->createGoods($input->getArgument('amount'))
            )
        );

    }
}