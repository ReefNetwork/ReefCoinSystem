<?php


namespace ree\sub\land;


use pocketmine\level\Level;
use pocketmine\math\Vector3;

interface ReefLandAPI_Base
{
	/**
	 * @param string $name
	 * @param Vector3 $start
	 * @param Vector3 $end
	 * @param Level $level
	 * @param bool $canUseWe
	 * @param bool $canUseSkill
	 * @param int $maxHeight
	 * @param int $maxEntityCount
	 * @return bool
	 */
	public static function addProtect(string $name , Vector3 $start , Vector3 $end , Level $level , bool $canUseWe , bool $canUseSkill , int $maxHeight = 256, int $maxEntityCount = 3 ): bool ;

	/**
	 * @param string $name
	 * @param Vector3 $vec3
	 * @param Level $level
	 * @return bool
	 */
	public static function isProtect(string $name ,Vector3 $vec3 ,Level $level): bool ;

	/**
	 * @param Vector3 $vec3
	 * @return string
	 *
	 * Returns the land id
	 * If not return null
	 */
	public static function getProtect(Vector3 $vec3): ?string ;

	/**
	 * @param string $id
	 * @return string|null
	 *
	 * Land owner is returned
	 * If not return null
	 */
	public static function getProtectOwner(string $id): ?string ;

	/**
	 * @param string $id
	 * @return bool
	 */
	public static function removeProtect(string $id): bool ;

	/**
	 * @param string $id
	 * @param string $name
	 * @return bool
	 */
	public static function addShareProtect(string $id ,string $name): bool ;

	/**
	 * @param string $id
	 * @param string $name
	 * @return bool
	 */
	public static function removeShareProtect(string $id ,string $name): bool ;

	/**
	 * @param string $id
	 * @return string|null
	 */
	public static function getMaxEntityCount(string $id): ?string ;

	/**
	 * @param string $id
	 * @return int|null
	 */
	public static function getEntityCount(string $id): ?int ;

	/**
	 * @param string $id
	 * @param int $count
	 * @return bool
	 */
	public static function setEntityCount(string $id ,int $count): bool ;

	/**
	 * @param string $id
	 * @return int|null
	 */
	public static function getMaxHeight(string $id): ?int ;

	/**
	 * @param string $id
	 * @param int $height
	 * @return bool
	 */
	public static function setMaxHeight(string $id ,int $height): bool ;

	/**
	 * @param string $id
	 * @return bool|null
	 */
	public static function isCanUseSkill(string $id): ?bool ;

	/**
	 * @param string $id
	 * @return bool
	 */
	public static function setCanUseSkill(string $id): bool ;

	/**
	 * @param string $id
	 * @return bool|null
	 */
	public static function isCanUseWe(string $id): ?bool ;

	/**
	 * @param string $id
	 * @return bool
	 */
	public static function setCanUseWe(string $id): bool ;
}