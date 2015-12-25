<?php
/**
 * Created by PhpStorm.
 * User: Alexey Teterin
 * Email: 7018407@gmail.com
 * Date: 23.12.2015
 * Time: 8:26
 */

namespace errogaht\PABTest\Console;

use errogaht\PABTest\DB;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class ListCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('list')
            ->setDescription('Shows list of tests');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $conn = DB::getConn();
        $data = $conn->fetchAll('SELECT * FROM variants');
        if (!empty($data)) {
            $result = [];
            foreach ($data as $row) {
                $result[$row['test_name']]['test_name'] = $row['test_name'];
                $result[$row['test_name']]['shows'] = 0;
                $result[$row['test_name']]['goals'] = 0;
            }

            foreach ($data as $row) {
                $result[$row['test_name']]['shows'] += $row['shows'];
                $result[$row['test_name']]['goals'] += $row['goals'];
            }

            foreach ($data as $row) {
                $result[$row['test_name']]['conversion'] = ($row['goals'] / $row['shows']) * 100 . " %";
            }
            $table = new Table($output);
            $table
                ->setHeaders(['Test name', 'Totals shows', 'Totals goals', 'Total conversion'])
                ->setRows($result);
            $table->render();
        } else {
            $output->writeln('<error>Test list is empty</error>');
        }

    }
}