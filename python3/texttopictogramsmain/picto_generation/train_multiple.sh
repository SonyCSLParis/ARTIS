#!/bin/bash

MODELS=("CompVis/stable-diffusion-v1-4" "runwayml/stable-diffusion-v1-5" "Lykon/DreamShaper")
#MODELS=("Lykon/DreamShaper")

export CUDA_VISIBLE_DEVICES=0

# Array of dataset suffixes
DATASET_SUFFIXES=("20" "150" "2000" "10000")
#DATASET_SUFFIXES=("20")

# Get the directory of the current script
SCRIPT_DIR="$(dirname "$(realpath "$0")")"

python3 "${SCRIPT_DIR}/Get_Pictos.py"

# Base output directory relative to the script directory
BASE_OUTPUT_DIR="${SCRIPT_DIR}/../Models/"

# Check if BASE_OUTPUT_DIR exists, if not, create it
if [ ! -d "$BASE_OUTPUT_DIR" ]; then
    mkdir -p "$BASE_OUTPUT_DIR"
fi

# Base directory relative to the script directory
BASE_DIR="${SCRIPT_DIR}/../Pictos/"

# Iterate over models
for MODEL in "${MODELS[@]}"; do
    # Model name without slashes
    MODEL_NAME=$(echo "$MODEL" | tr '/' '_')

    # Output directory prefix with model name
    OUTPUT_DIR_PREFIX="${BASE_OUTPUT_DIR}${MODEL_NAME}/output_model_"

    # Iterate over dataset suffixes
    for SUFFIX in "${DATASET_SUFFIXES[@]}"; do
        # Construct training directory path
        TRAIN_DIR="${BASE_DIR}pictos_${SUFFIX}"

        # Count the number of files in the training directory
        FILE_COUNT=$(ls -1q "$TRAIN_DIR" | wc -l)

        # Construct output directory path with the file count as the suffix
        OUTPUT_DIR="${OUTPUT_DIR_PREFIX}${FILE_COUNT}"

        # Check if OUTPUT_DIR exists, if not, create it
        if [ ! -d "$OUTPUT_DIR" ]; then
            mkdir -p "$OUTPUT_DIR"
        fi


        echo "Training Directory: $TRAIN_DIR"
        echo "Output Directory: $OUTPUT_DIR"
        echo "BASE_DIR Directory: $BASE_DIR"


        # Execute training script
        # /mnt/diskMartines/soufiane/.local/bin/accelerate launch "${SCRIPT_DIR}/train_text_to_image.py" \
        accelerate launch "${SCRIPT_DIR}/train_text_to_image.py" \
          --pretrained_model_name_or_path="$MODEL" \
          --train_data_dir="$TRAIN_DIR" \
          --use_ema \
          --resolution=500 --center_crop --random_flip \
          --train_batch_size=1 \
          --gradient_accumulation_steps=4 \
          --gradient_checkpointing \
          --mixed_precision="fp16" \
          --max_train_steps=1000 \
          --learning_rate=1e-05 \
          --max_grad_norm=1 \
          --lr_scheduler="constant" --lr_warmup_steps=0 \
          --output_dir="$OUTPUT_DIR"

        # Clear GPU memory cache
        python3 -c "import torch; torch.cuda.empty_cache()"
    done
done

python3 "${SCRIPT_DIR}/Gen_Picto_Model_Comps.py"
