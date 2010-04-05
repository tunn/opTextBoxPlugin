<?php
/**
 */
class PluginTextBoxTable extends Doctrine_Table
{
  const TYPE_FRIEND   = 1;
  const TYPE_PRIVATE  = 2;
  const TYPE_TWITTER  = 3;
  
  protected static $types = array(
    self::TYPE_FRIEND     => '%my_friend%',
    self::TYPE_PRIVATE    => 'Private',
    self::TYPE_TWITTER    => 'Twitter',
  );
  
  public function getTypes()
  {
    return self::$types;
  }
  
  protected function addFriendTextQuery(Doctrine_Query $q, $memberId)
  {
    $dql = 'member_id = ?';
    $dqlParams = array($memberId);
    $friendIds = Doctrine::getTable('MemberRelationship')->getFriendMemberIds($memberId);
    $types = array(self::TYPE_FRIEND, self::TYPE_TWITTER);
    if ($friendIds)
    {
      $query = new Doctrine_Query();
      $query->andWhereIn('member_id', $friendIds);
      $query->andWhereIn('type', $types);

      $dql .= ' OR '.implode(' ', $query->getDqlPart('where'));
      $dqlParams = array_merge($dqlParams, $friendIds, $types);
    }
    
    $q->andWhere('('.$dql.')', $dqlParams);
  }
  
  public function getTextList($memberId = null, $limit = 5)
  {
    $q = $this->createQuery('a')->orderBy('created_at DESC');
    $this->addFriendTextQuery($q, $memberId);
    if (null !== $limit)
    {
      $q->limit($limit);
    }

    return $q->execute();
  }
}