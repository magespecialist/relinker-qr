<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\ReLinkerQr\Model;

use Endroid\QrCode\ErrorCorrectionLevel;
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
     */
    public function __construct(
        int $size = 400,
        int $logoWidth = 200
    ) {
        $this->size = $size;
        $this->logoWidth = $logoWidth;
    }

    /**
     * Generate QR code
     * @param string $url
     * @param string $logoPath
     * @param string $file
     */
    public function execute(string $url, string $logoPath, string $file)
    {
        // @codingStandardsIgnoreStart
        $qrCode = new QrCode($url);
        // @codingStandardsIgnoreEnd

        if ($logoPath !== '') {
            $qrCode->setLogoPath($logoPath);
        }

        $qrCode->setSize($this->size);
        $qrCode->setLogoWidth($this->logoWidth);
        $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH());
        $qrCode->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0]);
        $qrCode->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0]);
        $qrCode->setEncoding('UTF-8');

        // @codingStandardsIgnoreStart
        $writer = new PngWriter();
        // @codingStandardsIgnoreEnd

        $writer->writeFile($qrCode, $file);
    }
}
