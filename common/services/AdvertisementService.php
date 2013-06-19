<?php
/**
 * 广告service
 * 
 * @author lizhran
 */
class AdvertisementService extends ActionService {

	/**
	 * 广告管理缓存
	 */
	const MEMCACHE_KEY_AD_URL = "select name,url from postfix.ad_url order by id asc";

	/**
	 * 根据id获取广告
	 * 
	 * @param $id int
	 */
	public function findAdvertisementById($id) {
		return Advertisement::model()->findByPk( $id );
	}

	/**
	 * 查询所有广告
	 */
	public function findAllAdvertisement() {
		$criteria = new CDbCriteria();
		$criteria->order = "id";
		return Advertisement::model()->findAll( $criteria );
	}

	/**
	 * 保存广告信息
	 * 
	 * @param $advertisement Advertisement
	 * @return boolean
	 */
	public function saveAdvertisement($advertisement) {
		$result = $advertisement->save();
		if ($result) {
			MemcacheHelper::deleteData( self::MEMCACHE_KEY_AD_URL );
		}
		return $result;
	}

	/**
	 * 根据广告id删除相应的样式
	 * 
	 * @param $ids string @int
	 */
	public function deleteAdvertisementByIds($ids) {
		Advertisement::model()->deleteAll( "id in ($ids)" );
		MemcacheHelper::deleteData( self::MEMCACHE_KEY_AD_URL );
	}

	/**
	 * 根据ids查询相应的广告信息
	 * 
	 * @param $ids string 广告信息的ids
	 */
	public function findAdvertisementByIds($ids) {
		return Advertisement::model()->findAll( "id in ($ids)" );
	}

	/**
	 * 更新memcache广告缓存数据
	 */
	private function setAdvertisementMemcache() {
		$advertisements = $this->findAllAdvertisement();
		$advertise_array = array ();
		$arrayIndex = 0;
		foreach ( $advertisements as $advertisement ) {
			if (! $advertisement ['name'])
				continue;
			$advertise_array [$arrayIndex] [0] = htmlspecialchars( $advertisement ['name'] );
			$advertise_array [$arrayIndex] [1] = htmlspecialchars( $advertisement ['url'] );
			$arrayIndex ++;
		}
		MemcacheHelper::setData( self::MEMCACHE_KEY_AD_URL, $advertise_array );
	}
}