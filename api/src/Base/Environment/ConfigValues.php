<?php

namespace App\Base\Environment;

class ConfigValues
{
    private string $app;
    private string $appPort;
    private string $environment;
    private string $dbUser;
    private string $dbPassword;
    private string $dbName;
    private string $dbHost;
    private string $dbPort;
    private  string $remoteAddr;

    public function getApp(): string
    {
        return $this->app;
    }

    public function setApp(string $app): void
    {
        $this->app = $app;
    }

    public function getAppPort(): string
    {
        return $this->appPort;
    }

    public function setAppPort(string $appPort): void
    {
        $this->appPort = $appPort;
    }

    public function getEnvironment(): string
    {
        return $this->environment;
    }

    public function setEnvironment(string $environment): void
    {
        $this->environment = $environment;
    }

    public function getDbUser(): string
    {
        return $this->dbUser;
    }

    public function setDbUser(string $dbUser): void
    {
        $this->dbUser = $dbUser;
    }

    public function getDbPassword(): string
    {
        return $this->dbPassword;
    }

    public function setDbPassword(string $dbPassword): void
    {
        $this->dbPassword = $dbPassword;
    }

    public function getDbName(): string
    {
        return $this->dbName;
    }

    public function setDbName(string $dbName): void
    {
        $this->dbName = $dbName;
    }

    public function getDbHost(): string
    {
        return $this->dbHost;
    }

    public function setDbHost(string $dbHost): void
    {
        $this->dbHost = $dbHost;
    }

    public function getDbPort(): string
    {
        return $this->dbPort;
    }

    public function setDbPort(string $dbPort): void
    {
        $this->dbPort = $dbPort;
    }

    public function getRemoteAddr(): string
    {
        return $this->remoteAddr;
    }

    public function setRemoteAddr(string $remoteAddr): void
    {
        $this->remoteAddr = $remoteAddr;
    }
}
