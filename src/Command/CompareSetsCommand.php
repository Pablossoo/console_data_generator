<?php

namespace App\Command;

use App\Collector\RuleCollection;
use App\Dictionary\FileExtension;
use App\Factory\FileFactory;
use App\Validator\Rules\ComparatorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;


class CompareSetsCommand extends Command
{
    protected static $defaultName = 'compare-sets';
    protected static $defaultDescription = 'compare each value from set A with value from B ';

    private RuleCollection $ruleCollection;
    private FileFactory $factory;
    private Filesystem $fileSystem;

    /**
     * CompareSetsCommand constructor.
     * @param ComparatorInterface $ruleCollection
     */
    public function __construct(RuleCollection $ruleCollection, FileFactory $factory, Filesystem $filesystem)
    {
        parent::__construct();
        $this->ruleCollection = $ruleCollection;
        $this->factory = $factory;
        $this->fileSystem = $filesystem;
    }

    protected function configure()
    {
        $this->setDescription(self::$defaultDescription);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $finder = new Finder();
        $files = $finder->files()->in(__DIR__ . '../../../var/tmp/');

        if ($files->hasResults() && $finder->count() !== 2) {
            throw new FileNotFoundException("Please first use command php bin/console generate:random-characters");
        }

        foreach ($finder as $element) {
            $contents[] = unserialize($element->getContents());
        }

        $resultCompare = $this->prepareHeadersWithDataInCsv([], $contents);

        $contentsArray = current($contents);

        if (empty($contentsArray)) {
            $io->error('Something went wrong');
            return Command::FAILURE;
        }
        foreach ($contentsArray as $key => $item) {
            foreach ($this->ruleCollection->getRules() as $key1 => $rule) {
                $resultCompare[$key1][$rule->getName()] = $rule->getName();
                $resultCompare[$rule->getName()][] = $rule->compare((int)$item, $contents[1][$key]);
            }
        }

        $csvFactory = $this->factory->createFile(FileExtension::CSV);

        if (!$this->fileSystem->exists('Export')) {
            $this->fileSystem->mkdir(__DIR__ . '../../Export/');
        }
        $csvFactory->saveToFile(__DIR__ . '/../Export/result.csv', $resultCompare);

        $io->success('Success!');
        return Command::SUCCESS;
    }

    private function prepareHeadersWithDataInCsv(array $resultCompare, array $dataFromFile): array
    {
        $resultCompare['testDataA']['testDataA'] = 'dane zestawu A';
        $resultCompare['testDataSetA']['testDataSetA'] = implode(',', $dataFromFile[0]);
        $resultCompare['testDataB']['testData'] = 'dane zestawu B';
        $resultCompare['testDataSetB']['testDataSetB'] = implode(',', $dataFromFile[1]);

        return $resultCompare;
    }
}
