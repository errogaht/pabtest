<?php
/**
 * Created by PhpStorm.
 * User: Alexey Teterin
 * Email: 7018407@gmail.com
 * Date: 23.12.2015
 * Time: 8:32
 */

namespace errogaht\PABTest\Console;


use errogaht\PABTest\DB;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ResultCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('result')
            ->setDescription('Show result for specified test')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'Test name'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $conn = DB::getConn();
        $data = $conn->fetchAll('SELECT * FROM variants WHERE test_name = ?', [$name]);
        if (!empty($data)) {
            $result = [];
            foreach ($data as $row) {
                $result[$row['variant']]['variant'] = $row['variant'];
                $result[$row['variant']]['shows'] = $row['shows'];
                $result[$row['variant']]['goals'] = $row['goals'];
                $result[$row['variant']]['conversion'] = ($row['goals'] / $row['shows']) * 100 . ' %';
            }

            $table = new Table($output);
            $table
                ->setHeaders([
                    [new TableCell('A\B test results for "' . $name . '"', ['colspan' => 4])],
                    ['Variant name', 'Shows', 'Goals', 'Conversion']
                ])
                ->setRows($result);
            $table->render();
        } else {
            $output->writeln('<error>Test with name "' . $name . '" not found</error>');
        }
    }
}