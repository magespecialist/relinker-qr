<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\ReLinkerQr\Model;

use MSP\ReLinker\Model\Walker\WalkerRepositoryInterface;
use MSP\ReLinkerApi\Api\Data\RouteInterface;
use MSP\ReLinkerApi\Api\RouteRepositoryInterface;

class Generate
{
    /**
     * @var RouteRepositoryInterface
     */
    private $routeRepository;

    /**
     * @var WalkerRepositoryInterface
     */
    private $walkerRepository;

    /**
     * @var GenerateQrCode
     */
    private $generateQrCode;

    public function __construct(
        RouteRepositoryInterface $routeRepository,
        WalkerRepositoryInterface $walkerRepository,
        GenerateQrCode $generateQrCode
    ) {
        $this->routeRepository = $routeRepository;
        $this->walkerRepository = $walkerRepository;
        $this->generateQrCode = $generateQrCode;
    }

    /**
     * Generate QR codes
     * @param string $routePath
     * @param string $logoPath
     * @param string $exportDir
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute(string $routePath, string $logoPath, string $exportDir)
    {
        $route = $this->routeRepository->getByPath($routePath);
        $processorCode = $route->getProcessor();

        $walker = $this->walkerRepository->getByCode($processorCode);
        $walker->execute($route, function (
            RouteInterface $route,
            string $pathPart,
            string $url
        ) use (
            $exportDir,
            $logoPath
        ) {
            $outFile = $exportDir . '/' . $pathPart . '.png';
            $this->generateQrCode->execute($url, $logoPath, $outFile);
        });
    }
}
