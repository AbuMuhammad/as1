<?php

/**
 * This is the model class for table "pegawai_config".
 *
 * The followings are the available columns in table 'pegawai_config':
 * @property string $id
 * @property string $pegawai_id
 * @property string $cuti_tahunan
 * @property integer $bpjs
 * @property string $tunjangan_anak
 * @property string $updated_at
 * @property string $updated_by
 * @property string $created_at
 *
 * The followings are the available model relations:
 * @property Pegawai $pegawai
 * @property User $updatedBy
 */
class PegawaiConfig extends CActiveRecord
{

    const BPJS_TIDAK_ADA = 0;
    const BPJS_ADA = 1;

    public $namaNipPegawai;
    public $keteranganPegawai;
    public $gajiTerkini;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'pegawai_config';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['pegawai_id', 'required', 'message' => '[{attribute}] harus dipilih!'],
            ['bpjs', 'numerical', 'integerOnly' => true],
            ['pegawai_id, updated_by', 'length', 'max' => 10],
            ['cuti_tahunan', 'length', 'max' => 5],
            ['tunjangan_anak', 'length', 'max' => 18],
            ['created_at, updated_at, updated_by', 'safe'],
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            ['id, pegawai_id, cuti_tahunan, bpjs, tunjangan_anak, updated_at, updated_by, created_at, namaNipPegawai, keteranganPegawai, gajiTerkini', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
            'pegawai' => [self::BELONGS_TO, 'Pegawai', 'pegawai_id'],
            'updatedBy' => [self::BELONGS_TO, 'User', 'updated_by'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pegawai_id' => 'Pegawai',
            'cuti_tahunan' => 'Cuti Tahunan (Hari)',
            'bpjs' => 'BPJS',
            'tunjangan_anak' => 'Tunjangan Anak',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'namaNipPegawai' => 'Nama/NIP',
            'keteranganPegawai' => 'Unit Kerja'
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('pegawai_id', $this->pegawai_id);
        $criteria->compare('cuti_tahunan', $this->cuti_tahunan, true);
        $criteria->compare('bpjs', $this->bpjs);
        $criteria->compare('tunjangan_anak', $this->tunjangan_anak, true);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('updated_by', $this->updated_by, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->with = ['pegawai'];
        $criteria->compare('CONCAT(pegawai.nama,pegawai.nip)', $this->namaNipPegawai, true);
        $criteria->compare("(SELECT CONCAT(cabang.nama,bagian.nama,jabatan.nama) FROM pegawai_mutasi JOIN (SELECT pegawai_id, MAX(per_tanggal) per_tanggal FROM pegawai_mutasi GROUP BY pegawai_id) t_max ON t_max.pegawai_id = pegawai_mutasi.pegawai_id AND t_max.per_tanggal = pegawai_mutasi.per_tanggal JOIN cabang ON cabang.id = pegawai_mutasi.cabang_id JOIN bagian ON bagian.id = pegawai_mutasi.bagian_id JOIN jabatan ON jabatan.id = pegawai_mutasi.jabatan_id WHERE pegawai_mutasi.pegawai_id = t.pegawai_id)", $this->keteranganPegawai, true);
        $criteria->compare("(SELECT gaji FROM pegawai_gaji WHERE pegawai_id = t.pegawai_id ORDER BY per_tanggal DESC LIMIT 1)", $this->gajiTerkini, true);

        $sort = [
            'defaultOrder' => 't.id desc',
            'attributes' => [
                'namaNipPegawai' => [
                    'asc' => 'CONCAT(pegawai.nama,pegawai.nip)',
                    'desc' => 'CONCAT(pegawai.nama,pegawai.nip) desc'
                ],
                'keteranganPegawai' => [
                    'asc' => '(SELECT CONCAT(cabang.nama,bagian.nama,jabatan.nama) FROM pegawai_mutasi JOIN (SELECT pegawai_id, MAX(per_tanggal) per_tanggal FROM pegawai_mutasi GROUP BY pegawai_id) t_max ON t_max.pegawai_id = pegawai_mutasi.pegawai_id AND t_max.per_tanggal = pegawai_mutasi.per_tanggal JOIN cabang ON cabang.id = pegawai_mutasi.cabang_id JOIN bagian ON bagian.id = pegawai_mutasi.bagian_id JOIN jabatan ON jabatan.id = pegawai_mutasi.jabatan_id WHERE pegawai_mutasi.pegawai_id = t.pegawai_id)',
                    'desc' => '(SELECT CONCAT(cabang.nama,bagian.nama,jabatan.nama) FROM pegawai_mutasi JOIN (SELECT pegawai_id, MAX(per_tanggal) per_tanggal FROM pegawai_mutasi GROUP BY pegawai_id) t_max ON t_max.pegawai_id = pegawai_mutasi.pegawai_id AND t_max.per_tanggal = pegawai_mutasi.per_tanggal JOIN cabang ON cabang.id = pegawai_mutasi.cabang_id JOIN bagian ON bagian.id = pegawai_mutasi.bagian_id JOIN jabatan ON jabatan.id = pegawai_mutasi.jabatan_id WHERE pegawai_mutasi.pegawai_id = t.pegawai_id) desc'
                ],
                'gajiTerkini' => [
                    'asc' => '(SELECT gaji FROM pegawai_gaji WHERE pegawai_id = t.pegawai_id ORDER BY per_tanggal DESC LIMIT 1)',
                    'desc' => '(SELECT gaji FROM pegawai_gaji WHERE pegawai_id = t.pegawai_id ORDER BY per_tanggal DESC LIMIT 1) desc'
                ],
                '*'
            ]
        ];

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'sort' => $sort
        ]);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PegawaiConfig the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeSave()
    {

        if ($this->isNewRecord) {
            $this->created_at = date('Y-m-d H:i:s');
        }
        $this->updated_at = null; // Trigger current timestamp
        $this->updated_by = Yii::app()->user->id;
        return parent::beforeSave();
    }

    public static function listBpjs()
    {
        return [
            self::BPJS_TIDAK_ADA => 'Tidak',
            self::BPJS_ADA => 'Ada',
        ];
    }

    public function getNamaBpjs()
    {
        return $this->listBpjs()[$this->bpjs];
    }

    public function getNamaNipPegawai()
    {
        return $this->pegawai->nama . ' / ' . $this->pegawai->nip;
    }

    public function getKeteranganPegawai()
    {
        return $this->pegawai->cabangTerakhir . ' | ' . $this->pegawai->bagianTerakhir . ' | ' . $this->pegawai->jabatanTerakhir;
    }

    public function getGajiTerakhirRaw()
    {
        $hasil = Yii::app()->db->createCommand("
            select gaji
            from " . PegawaiGaji::model()->tableName() . "
            where pegawai_id = {$this->pegawai_id}
            order by per_tanggal desc
            limit 1
			  ")->queryRow();
        return $hasil['gaji'];
    }

    public function getGajiTerakhir()
    {
        return number_format($this->getGajiTerakhirRaw(), 2, ',', '.');
    }

}
