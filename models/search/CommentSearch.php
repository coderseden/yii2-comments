<?php

namespace coderseden\cmt\models\search;

use yii\data\ActiveDataProvider;
use coderseden\cmt\models\CommentModel;

/**
 * Class CommentSearch
 *
 * @package coderseden\cmt\models\search
 */
class CommentSearch extends CommentModel
{
    /**
     * @var int the default page size
     */
    public $pageSize = 10;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'createdBy', 'status'], 'integer'],
            [['content', 'relatedTo'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param $params
     *
     * @return ActiveDataProvider
     */
    public function search(array $params)
    {
        $query = CommentModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->pageSize,
            ],
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['id' => SORT_DESC],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'createdBy' => $this->createdBy,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content]);
        $query->andFilterWhere(['like', 'relatedTo', $this->relatedTo]);

        return $dataProvider;
    }
}
