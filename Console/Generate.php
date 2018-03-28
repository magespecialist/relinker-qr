<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\ReLinkerQr\Console;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\ObjectManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Generate extends Command
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * SendMessage constructor.
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(
        ObjectManagerInterface $objectManager
    ) {
        parent::__construct();
        $this->objectManager = $objectManager;
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('msp:relinker:qr:generate');
        $this->setDescription('Generate QR codes');

        $this->addArgument('routePath', InputArgument::REQUIRED, 'QR codes path');
        $this->addArgument('logoPath', InputArgument::OPTIONAL, 'Logo path');

        parent::configure();
    }

    /**
     * @inheritdoc
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $routePath = $input->getArgument('routePath');
        $logoPath = $input->getArgument('logoPath');

        // @codingStandardsIgnoreStart
        // Must use object manager here
        /** @var \MSP\ReLinkerQr\Model\Generate $generate */
        $generate = $this->objectManager->get(\MSP\ReLinkerQr\Model\Generate::class);

        /** @var DirectoryList $directoryList */
        $directoryList = $this->objectManager->get(DirectoryList::class);

        /** @var File $fileIo */
        $fileIo = $this->objectManager->get(File::class);
        // @codingStandardsIgnoreEnd

        if ($logoPath) {
            $logoPath = $directoryList->getPath(DirectoryList::MEDIA) . '/' . $logoPath;
        } else {
            $logoPath = '';
        }

        $destPath = $directoryList->getPath(DirectoryList::MEDIA) .
            '/msp_relinker_qr/' . preg_replace('/\W+/', '_', $routePath);

        if (!$fileIo->fileExists($destPath)) {
            $fileIo->mkdir($destPath, 0755);
        }

        $generate->execute($routePath, $logoPath, $destPath);
    }
}
