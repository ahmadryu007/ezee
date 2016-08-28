USE [master]
GO

/****** Object:  Database [crm_ezeelink]    Script Date: 08/26/2016 13:49:35 ******/
CREATE DATABASE [crm_ezeelink] ON  PRIMARY 
( NAME = N'crm_ezeelink', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL10.MSSQLSERVER\MSSQL\DATA\crm_ezeelink.mdf' , SIZE = 7168KB , MAXSIZE = UNLIMITED, FILEGROWTH = 1024KB )
 LOG ON 
( NAME = N'crm_ezeelink_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL10.MSSQLSERVER\MSSQL\DATA\crm_ezeelink_log.ldf' , SIZE = 1280KB , MAXSIZE = 2048GB , FILEGROWTH = 10%)
GO

ALTER DATABASE [crm_ezeelink] SET COMPATIBILITY_LEVEL = 100
GO

IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [crm_ezeelink].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO

ALTER DATABASE [crm_ezeelink] SET ANSI_NULL_DEFAULT OFF 
GO

ALTER DATABASE [crm_ezeelink] SET ANSI_NULLS OFF 
GO

ALTER DATABASE [crm_ezeelink] SET ANSI_PADDING OFF 
GO

ALTER DATABASE [crm_ezeelink] SET ANSI_WARNINGS OFF 
GO

ALTER DATABASE [crm_ezeelink] SET ARITHABORT OFF 
GO

ALTER DATABASE [crm_ezeelink] SET AUTO_CLOSE OFF 
GO

ALTER DATABASE [crm_ezeelink] SET AUTO_CREATE_STATISTICS ON 
GO

ALTER DATABASE [crm_ezeelink] SET AUTO_SHRINK OFF 
GO

ALTER DATABASE [crm_ezeelink] SET AUTO_UPDATE_STATISTICS ON 
GO

ALTER DATABASE [crm_ezeelink] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO

ALTER DATABASE [crm_ezeelink] SET CURSOR_DEFAULT  GLOBAL 
GO

ALTER DATABASE [crm_ezeelink] SET CONCAT_NULL_YIELDS_NULL OFF 
GO

ALTER DATABASE [crm_ezeelink] SET NUMERIC_ROUNDABORT OFF 
GO

ALTER DATABASE [crm_ezeelink] SET QUOTED_IDENTIFIER OFF 
GO

ALTER DATABASE [crm_ezeelink] SET RECURSIVE_TRIGGERS OFF 
GO

ALTER DATABASE [crm_ezeelink] SET  DISABLE_BROKER 
GO

ALTER DATABASE [crm_ezeelink] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO

ALTER DATABASE [crm_ezeelink] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO

ALTER DATABASE [crm_ezeelink] SET TRUSTWORTHY OFF 
GO

ALTER DATABASE [crm_ezeelink] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO

ALTER DATABASE [crm_ezeelink] SET PARAMETERIZATION SIMPLE 
GO

ALTER DATABASE [crm_ezeelink] SET READ_COMMITTED_SNAPSHOT OFF 
GO

ALTER DATABASE [crm_ezeelink] SET HONOR_BROKER_PRIORITY OFF 
GO

ALTER DATABASE [crm_ezeelink] SET  READ_WRITE 
GO

ALTER DATABASE [crm_ezeelink] SET RECOVERY FULL 
GO

ALTER DATABASE [crm_ezeelink] SET  MULTI_USER 
GO

ALTER DATABASE [crm_ezeelink] SET PAGE_VERIFY CHECKSUM  
GO

ALTER DATABASE [crm_ezeelink] SET DB_CHAINING OFF 
GO

