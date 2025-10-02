<?php
namespace TamersNetwork\Model;

class DigimonData
{
    public string $attrToDisplay;
    public array $traitCommon;
    public array $traitSpecific;
    public function __construct(
        public readonly int $digimonId,
        public string $name,
        public string $image,
        public string $stage,
        public string $element,
        public string $attr,
        public string $rank,
        public string $family,
        public string $class,
        public int $buildStr,
        public int $buildAgi,
        public int $buildCon,
        public int $buildInt,
        public int $traitCommon1,
        public int $traitCommon2,
        public int $traitCommon3,
        public int $traitSpecific1,
        public int $traitSpecific2,
        public int $traitSpecific3,
        public string $skillText1,
        public string $skillText2,
        public string $skillText3,
    ) {
        $this->processDigimonData();
    }
    public static function fromDatabaseRow(array $data): self
    {
        // É AQUI que a tradução de snake_case para camelCase acontece agora.
        // Toda a lógica de mapeamento está encapsulada dentro da própria classe.
        return new self(
            digimonId: (int) ($data['digimon_id'] ?? 0),
            name: $data['name'] ?? '',
            image: $data['image'] ?? '',
            stage: $data['stage'] ?? '',
            element: $data['element'] ?? '',
            attr: $data['attr'] ?? '',
            rank: $data['rank'] ?? '',
            family: $data['family'] ?? '',
            class: $data['class'] ?? '',
            buildStr: (int) ($data['build_str'] ?? 0),
            buildAgi: (int) ($data['build_agi'] ?? 0),
            buildCon: (int) ($data['build_con'] ?? 0),
            buildInt: (int) ($data['build_int'] ?? 0),
            traitCommon1: (int) ($data['trait_common_1'] ?? 0),
            traitCommon2: (int) ($data['trait_common_2'] ?? 0),
            traitCommon3: (int) ($data['trait_common_3'] ?? 0),
            traitSpecific1: (int) ($data['trait_specific_1'] ?? 0),
            traitSpecific2: (int) ($data['trait_specific_2'] ?? 0),
            traitSpecific3: (int) ($data['trait_specific_3'] ?? 0),
            skillText1: $data['skill_text1'] ?? '',
            skillText2: $data['skill_text2'] ?? '',
            skillText3: $data['skill_text3'] ?? '',
        );
    }

    public function processDigimonData()
    {
        $a['va'] = 'Vaccine';
        $a['vi'] = 'Virus';
        $a['da'] = 'Data';
        $a['un'] = 'Unknown';
        $this->attrToDisplay = $a[$this->attr] ?? 'Unknown';

        if ($this->traitCommon1 != 0) {
            $this->traitCommon[] = new TraitCommon();
        }
    }
}
?>