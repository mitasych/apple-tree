<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Apple;
use yii\helpers\ArrayHelper;

/**
 * AppleSearch represents the model behind the search form of `common\models\Apple`.
 */
class AppleSearch extends Apple
{
    public $percent;
    public $create_date_start;
    public $create_date_end;
    public $fallen_date_start;
    public $fallen_date_end;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'color_id', 'state', 'percent', 'created_at', 'fallen_at'], 'integer'],
            [['create_date_start', 'create_date_end'], 'string']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Apple::find()->active();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'color_id',
                'state',
                'percent' => [
                    'asc' => ['size' => SORT_ASC],
                    'desc' => ['size' => SORT_DESC],
                ],
                'created_at',
                'fallen_at'
            ],
            'defaultOrder' => [
                'id' => SORT_DESC
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (!empty($this->percent)) {
            $this->size = $this->percent / 100;
        }

        if (!empty($this->create_date_start)) {
            $timestampStart = strtotime($this->create_date_start);
            $query->andFilterWhere(['>=', 'created_at', $timestampStart]);

            if (empty($this->create_date_end)) {
                $timestampEnd = strtotime($this->create_date_start) + 24 * 60 * 60;
                $query->andFilterWhere(['<=', 'created_at', $timestampEnd]);
            }
            else {
                $timestampEnd = strtotime($this->create_date_end) + 24 * 60 * 60;
                $query->andFilterWhere(['<=', 'created_at', $timestampEnd]);
            }
        }

        if (!empty($this->fallen_date_start)) {
            $timestampStart = strtotime($this->fallen_date_start);
            $query->andFilterWhere(['>=', 'fallen_at', $timestampStart]);

            if (empty($this->fallen_date_end)) {
                $timestampEnd = strtotime($this->fallen_date_start) + 24 * 60 * 60;
                $query->andFilterWhere(['<=', 'fallen_at', $timestampEnd]);
            }
            else {
                $timestampEnd = strtotime($this->fallen_date_start) + 24 * 60 * 60;
                $query->andFilterWhere(['<=', 'fallen_at', $timestampEnd]);
            }
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'color_id' => $this->color_id,
            'state' => $this->state,
            'size' => $this->size,
            'fallen_at' => $this->fallen_at,
        ]);

        return $dataProvider;
    }
}
