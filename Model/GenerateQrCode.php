<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\ReLinkerQr\Model;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class GenerateQrCode
{
    /**
     * @var int
     */
    private $size;

    /**
     * @var int
     */
    private $logoWidth;

    /**
     * @var string
     */
    private $errorCorrectionLevel;

    /**
     * GenerateQrCode constructor.
     * @param int $size
     * @param int $logoWidth
     * @param string $errorCorrectionLevel
     */
    public function __construct(
        int $size = 400,
        int $logoWidth = 200,
        string $errorCorrectionLevel = 'high'
    ) {
        $this->size = $size;
        $this->logoWidth = $logoWidth;
        $this->errorCorrectionLevel = $errorCorrectionLevel;
    }

    /**
     * Generate QR code
     * @param string $url
     * @param string $logoPath
     * @param string $file
     * @throws \Endroid\QrCode\Exception\InvalidPathException
     */
    public function execute(string $url, string $logoPath, string $file)
    {
    // @codingStandardsIgnoreStart
        $qrCode = new QrCode($url);
        // @codingStandardsIgnoreEnd

        if ($logoPath !== '') {
            $qrCode->setLogoPath($logoPath);
        }

        $qrCode
            ->setSize($this->size)
            ->setLogoWidth($this->logoWidth)
            ->setErrorCorrectionLevel($this->errorCorrectionLevel)
            ->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0])
            ->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0])
            ->setEncoding('UTF-8');

        // @codingStandardsIgnoreStart
        $writer = new PngWriter();
        // @codingStandardsIgnoreEnd

        $writer->writeFile($qrCode, $file);
    }
}
