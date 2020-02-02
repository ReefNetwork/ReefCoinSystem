<?php


namespace ree\sub\land\sql;


use pocketmine\level\Level;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;

interface LandDataBaseManager_Base
{
	/**
	 * LandDataBaseManager_Base constructor.
	 * @param string $pass
	 */
	public function __construct(string $pass);

	/**
	 * @param string $id
	 * @return bool
	 */
	public function isExists(string $id): bool ;

	/**
	 * @param Vector3 $vec3
	 * @param Level $level
	 * @return string
	 */
	public function getProtect(Vector3 $vec3 ,Level $level): ?string ;

	/**
	 * @param string $name
	 * @param AxisAlignedBB $bb
	 * @param Level $level
	 * @param string $id
	 * @param Vector3 $spawnPoint
	 * @param int $maxHeight
	 * @param int $maxEntityCount
	 * @param bool $canUseSkill
	 * @return bool
	 */
	public function setProtect(string $name ,AxisAlignedBB $bb ,Level $level ,string $id ,Vector3 $spawnPoint,int $maxHeight ,int $maxEntityCount ,bool $canUseSkill): bool ;

	/**
	 * @param string $id
	 * @return bool
	 */
	public function removeProtect(string $id): bool ;

	/**
	 * @param string $id
	 * @return string|null
	 */
	public function getOwner(string $id): ?string ;

	/**
	 * @param string $id
	 * @param string $name
	 * @return bool
	 */
	public function setOwner(string $id ,string $name): bool ;

	/**
	 * @param string $id
	 * @return AxisAlignedBB|null
	 */
	public function getPosition(string $id): ?AxisAlignedBB ;

	/**
	 * @param string $id
	 * @param AxisAlignedBB $bb
	 * @return bool
	 */
	public function setPosition(string $id ,AxisAlignedBB $bb): bool ;

	/**
	 * @param string $id
	 * @return Level|null
	 */
	public function getLevel(string $id): ?Level ;

	/**
	 * @param string $id
	 * @param Level $level
	 * @return bool
	 */
	public function setLevel(string $id ,Level $level): bool ;

	/**
	 * @param string $id
	 * @return int|null
	 */
	public function getMaxHeight(string $id): ?int ;

	/**
	 * @param string $id
	 * @param int $height
	 * @return bool
	 */
	public function setMaxHeight(string $id ,int $height): bool ;

	/**
	 * @param string $id
	 * @return int|null
	 */
	public function getMaxEntityCount(string $id): ?int ;

	/**
	 * @param string $id
	 * @param int $count
	 * @return bool
	 */
	public function setMaxEntityCount(string $id ,int $count): bool ;

	/**
	 * @param string $id
	 * @return int|null
	 */
	public function getEntityCount(string $id): ?int ;

	/**
	 * @param string $id
	 * @param int $count
	 * @return bool
	 */
	public function setEntityCount(string $id ,int $count): bool ;

	/**
	 * @param string $id
	 * @return bool
	 */
	public function getUseSkill(string $id): bool ;

	/**
	 * @param string $id
	 * @param bool $bool
	 * @return bool
	 */
	public function setUseSkill(string $id ,bool $bool): bool ;

	/**
	 * @param string $id
	 * @return string|null
	 */
	public function getSubUsers(string $id): ?string ;

	/**
	 * @param string $id
	 * @param string $users
	 * @return bool
	 */
	public function setSubUsers(string $id ,string $users): bool ;

	/**
	 * @param string $id
	 * @return Vector3|null
	 */
	public function getSpawnPoint(string $id): ?Vector3 ;

	/**
	 * @param string $id
	 * @param Vector3 $vec3
	 * @return bool
	 */
	public function setSpawnPoint(string $id ,Vector3 $vec3): bool ;
}